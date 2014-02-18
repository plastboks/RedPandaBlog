<?php
/**
 * File: InstallController
 *
 * PHP version 5.4
 *
 * @category Development
 * @package  BaseController
 * @author   Alexander Skjolden <alex@plastboks.net>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License
 *
 * @link     http://github.com/plastboks/RedPandaBlog
 * @date     2013-06-17
 *
 */


/**
 * Class InstallController
 *
 * @category Development
 * @package  BaseController
 * @author   Alexander Skjolden <alex@plastboks.net>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License
 *
 * @link     http://github.com/plastboks/RedPandaBlog
 * @date     2013-06-17
 *
 */
class InstallController extends BaseController
{

    /**
     * Index view
     *
     * @return view
     */
    public function getIndex()
    {
        if (User::first()) {
            return Redirect::to('/')
                      ->with('status', 'Users exists');
        }

        $data = array(
            'username' => Session::get('username'),
            'email' => Session::get('email'),
            'givenname' => Session::get('givenname'),
            'surname' => Session::get('surname'),
        );
        return View::make('install', $data);
    }

    /**
     * Create user action
     *
     * @return redirect
     */
    public function postCreateuser()
    {
        if (User::first()) {
            return Redirect::to('/')
                            ->with('flashError', 'Users exists');
        }

        $v = Validator::make(Input::all(), User::defaultRules());

        if ($v->fails()) {
            return Redirect::back()
                      ->withErrors($v)
                      ->withInput()
                      ->with('username', Input::get('username'))
                      ->with('email', Input::get('email'))
                      ->with('givenname', Input::get('givenname'))
                      ->with('surname', Input::get('surname'));
        }

        $user = new User();
        $user->username = Input::get('username');
        $user->email = Input::get('email');
        $user->givenname = Input::get('givenname');
        $user->surname = Input::get('surname');
        $user->active = true;
        $user->role_id = 1;
        $user->password = Hash::make(Input::get('password'));
        $user->save();
        return Redirect::to('login')
                  ->with('flashSuccess', 'New user created');
    }

}

