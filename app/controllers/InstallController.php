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
 * @link     http://github.com/plastboks/red-panda-blog
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
 * @link     http://github.com/plastboks/red-panda-blog
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
            'status' => Session::get('status'),
            'username' => Session::get('username'),
            'email' => Session::get('email'),
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
                            ->with('status', 'Users exists');
        }

        $v = Validator::make(Input::all(), User::defaultRules());

        if ($v->fails()) {
            return Redirect::back()
                      ->withErrors($v)
                      ->withInput()
                      ->with('username', Input::get('username'))
                      ->with('email', Input::get('email'));
        }

        $user = new User();
        $user->username = Input::get('username');
        $user->email = Input::get('email');
        $user->role_id = 1;
        $user->password = Hash::make(Input::get('password'));
        $user->save();
        return Redirect::to('login')
                  ->with('status', 'New user created');
    }

}

