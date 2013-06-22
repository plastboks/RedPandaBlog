<?php
/**
 * AuthController
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
 * Class AuthController
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
class AuthController extends BaseController
{

    /**
     * Login view
     *
     * @return view
     */
    public function getLogin()
    {
        if (!Auth::guest()) {
            return Redirect::to('/');
        }
        return View::make('auth/login');
    }

    /**
     * Logout action
     *
     * @return redirect
     */
    public function getLogout()
    {
        Auth::logout();
        return Redirect::to('login');
    }

    /**
     * Forgot password view
     *
     * @return redirect
     */
    public function getForgot()
    {
        if (!Auth::guest()) {
            return Redirect::to('/');
        }
        return View::make('auth/forgot');
    }

    /**
     * New password view
     *
     * @return redirect
     */
    public function getNewPassword()
    {
        if (!Auth::guest()) {
            return Redirect::to('/');
        }

        if (!Input::has('token')) {
            return Redirect::to('/');
        }

        if (!User::where('confirmation_code', '=', Input::get('token'))->first()) {
            return Redirect::to('/');
        }

        $data = array(
                    'status' => Session::get('status'),
                    'error' => Session::get('error'),
                    'token' => Input::get('token'),
                );
        return View::make('auth/newpassword', $data);
    }

    /**
     * Try to login user action
     *
     * @return redirect
     */
    public function postTry()
    {
        $userdata = array(
            'email' => Input::get('email'),
            'password' => Input::get('password'),
            'blocked' => null,
        );

        if (Auth::attempt($userdata, Input::get('remember_me'))) {
            return Redirect::to('account');
        } else {
            return Redirect::to('login')
                      ->with('login_errors', true);
        }
    }

    /**
     * Send forgot password action
     *
     * @return redirect
     */
    public function postSendmail()
    {
        $v = Validator::make(Input::all(), User::forgotPassword());

        if ($v->fails()) {
            return Redirect::to('auth/forgot')
                            ->withErrors($v)
                            ->withInput();
        }

        if ($user = User::where('email', '=', Input::get('email'))->first()) {
            $rnd = $this->_genRndStr();
            $user->confirmation_code = substr(Hash::make($rnd.$user->email), 7);
            $user->save();
            $data = array(
              'token' => $user->confirmation_code,
            );
            Mail::send(
                'emails.auth.reminder', $data, function ($message) use ($user) {
                    $message->to($user->email, $user->username)
                        ->subject('Reset email for ...');
                }
            );
            return Redirect::to('/');
        }
        return Redirect::to('/');
    }

    /**
     * Send forgot password action
     *
     * @return redirect
     */
    public function postSetnewpass()
    {
        if (!Input::has('confirmcode')) {
            return Redirect::to('/');
        }

        $cD = Input::get('confirmcode');

        if (!$user = User::where('confirmation_code', '=', $cD)->first()
        ) {
            return Redirect::to('/');
        }

        $v = Validator::make(Input::all(), User::passwordRules());
        if ($v->fails()) {
            return Redirect::back()
                            ->withErrors($v)
                            ->withInput();
        }

        $user->confirmation_code = false;
        $user->password = Hash::make(Input::get('password'));
        $user->save();
        return Redirect::to('login');
    }

    /**
     * Generate random string
     *
     * @param int $len return length
     *
     * @return string
     */
    private function _genRndStr($len = 32)
    {
        $char  = "0123456789abcdefghijklmnopqrs";
        $char .= "iuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $rndStr = '';

        for ($i = 0; $i < $len; $i++) {
            $rndStr .= $char[rand(0, strlen($char) - 1)];
        }
        return $rndStr;
    }

}

