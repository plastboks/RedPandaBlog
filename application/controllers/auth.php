<?php

class Auth_Controller extends Base_Controller {

  public function action_login() {
    if (!Auth::guest()) return Redirect::to('/'); 
    return View::make('auth/login');
  }

  public function action_logout() {
    Auth::logout();
    return Redirect::to('login');
  }

  public function action_forgot() {
    if (!Auth::guest()) return Redirect::to('/'); 
    return View::make('auth/forgot');
  }

  public function action_try() {
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
  
  public function action_sendemail() {

    $v = Validator::make(Input::all(), User::forgotPassword());

    if ($v->fails()) {
      return Redirect::to('auth/forgot')
              ->with_errors($v)
              ->with_input();
    }
  
    if ($user = User::where('email', '=', Input::get('email'))->first()) {
      $salt = $this->gen_rndstr();
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

  private function gen_rndstr($len = 32) {
    $char  = "0123456789abcdefghijklmnopqrs";
    $char .= "iuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $rndStr = '';

    for ($i = 0; $i < $len; $i++) {
      $rndStr .= $char[rand(0, strlen($char) - 1)];
    }
    return $rndStr;
  }
}
