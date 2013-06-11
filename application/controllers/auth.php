<?php

class Auth_Controller extends Base_Controller {

  public function action_login() {
    return View::make('login');
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
        return Redirect::to('login')->with('login_errors', true);
      } else {
        return Redirect::to('account');
      }
    } else {
      return Redirect::to('login')->with('login_errors', true);
    }
  }

  public function action_logout() {
    Auth::logout();
    return Redirect::to('login');
  }

}
