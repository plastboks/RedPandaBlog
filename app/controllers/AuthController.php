<?php

class AuthController extends BaseController 
{

    /**
     * Login view
     *
     * @return view
     */
    public function getLogin() 
    {
        if (!Auth::guest()) return Redirect::to('/'); 
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
        if (!Auth::guest()) return Redirect::to('/'); 
        return View::make('auth/forgot');
    }

    /**
     * Try to login user action
     *
     * @return redirect
     */
    public function postTry() 
    {
        $userdata = array(
            'username' => Input::get('email'),
            'password' => Input::get('password'),
        );

        if (Auth::attempt($userdata, Input::get('remember_me'))) {
            $user = Auth::user();
            if ($user->blocked) {
                Auth::logout();
                return Redirect::to('login')
                          ->with('login_errors', true);
            } else {
                return Redirect::to('account');
            }
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
    public function postSendemail() 
    {

        $v = Validator::make(Input::all(), User::forgotPassword());

        if ($v->fails()) {
            return Redirect::to('auth/forgot')
                            ->withErrors($v)
                            ->withInput();
        }
    
        if ($user = User::where('email', '=', Input::get('email'))->first()) {
            $salt = $this->genRndstr();
            $email = 'alex@plastboks.net';
            $user->confirmation_code = substr(Hash::make($salt.$email), 7);
            $user->save();
            Mail::send('emails.forgot', $data, function($message){
                $message->to($user->email, $user->username)
                        ->subject('Reset email for ...');
            });
            return Redirect::to('/');
        }

        return Redirect::to('/');
    }

    /**
     * Generate random string
     *
     * @return string
     */
    private function genRndstr($len = 32) 
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

