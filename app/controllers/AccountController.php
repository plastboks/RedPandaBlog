<?php
/**
 * AccountController
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
 * Class AccountController
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
class AccountController extends BaseController
{

    /**
     * Sets persmission and loads the parents contruct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->beforeFilter('auth');
    }

    /**
     * Index view
     *
     * @return view
     */
    public function getIndex()
    {
        return View::make('account/welcome');
    }

    /**
     * Profile view
     *
     * @return view
     */
    public function getProfile()
    {
        $data = array(
            'user' => Auth::user(),
        );
        return View::make('account/profile', $data);
    }

    /**
     * Password view
     *
     * @return view
     */
    public function getPassword()
    {
        return View::make('account/password');
    }

    /**
     * Myposts view
     *
     * @return view
     */
    public function getMyposts()
    {
        $user = User::find(Auth::user()->id);
        $data = array(
            'posts' => $user->posts()->paginate(10),
        );
        return View::make('account/myposts', $data);
    }

    /**
     * Update user action
     *
     * @return redirect
     */
    public function postUpdate()
    {
        $user = Auth::user();

        $v = Validator::make(Input::all(), User::defaultRules($user->id));

        if ($v->fails()) {
            return Redirect::back()
                      ->with('user', Auth::user())
                      ->withErrors($v)
                      ->withInput();
        }

        if ($dbUser = User::find($user->id)) {
            $dbUser->username = Input::get('username');
            $dbUser->email = Input::get('email');
            $dbUser->givenname = Input::get('givenname');
            $dbUser->surname = Input::get('surname');
            $dbUser->info = Input::get('info');
            $dbUser->save();
            return Redirect::back()
                       ->with('user', Auth::user())
                       ->with('flashStatus', 'User updated!');
        }
    }

    /**
     * Changepassword action
     *
     * @return redirect
     */
    public function postChangepassword()
    {
        $user = User::find(Auth::user()->id);

        $v = Validator::make(Input::all(), User::passwordRules());

        if ($v->fails()) {
            return Redirect::back()
                      ->withErrors($v)
                      ->withInput();
        }

        if ($user) {
            if (Hash::check(Input::get('old_password'), $user->password)) {
                $user->password = Hash::make(Input::get('password'));
                $user->save();
                return Redirect::back()
                          ->with('flashStatus', 'Password changed');
            } else {
                return Redirect::back()
                          ->with('flashError', 'Incorrect password');
            }
        }

        return App::abort(403, 'Forbidden');
    }

}

