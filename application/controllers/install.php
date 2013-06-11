<?php

class Install_Controller extends Base_Controller {

  public function action_index() {
    if (User::all()) {
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

  public function action_createuser() {
    if (User::all()) {
      return Redirect::to('/')
              ->with('status', 'Users exists');
    }
    $v = Validator::make(Input::all(), User::defaultRules());
    if ($v->fails()) {
      return Redirect::to('install')
              ->with_errors($v)
              ->with('username', Input::get('username'))
              ->with('email', Input::get('email'))
              ->with_input();
    }

    $user = new User();
    $user->username = Input::get('username');
    $user->email = Input::get('email');
    $user->role = 1;
    $user->password = Hash::make(Input::get('password'));
    $user->save();
    return Redirect::to('/')
            ->with('status', 'New user created');
  }

}
