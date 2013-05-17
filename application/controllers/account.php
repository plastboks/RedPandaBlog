<?php 

class Account_Controller extends Base_Controller {
  
  public function __construct() {
    $this->filter('before', 'auth');
  }

  public function action_index() {
    $this->filter('before', 'auth');
    return View::make('account/welcome');
  }

  public function action_profile() {
    $data = array(
      'user' => Auth::user(),
    );
    return View::make('account/profile', $data);
  }
  
  public function action_update() {
    $user = Auth::user();
    $new_data = array(
      'username' => Input::get('username'),
      'email' => Input::get('email'),
      'password' => Input::get('password'),
      'password_confirmation' => Input::get('password_confirmation'),
    );

    $rules = array(
      'username' => "required|min:3|max:32|unique:users,username,{$user->id}",
      'email'  => "required|email|max:64|unique:users,email,{$user->id}",
      'password' => 'required|confirmed|max:64',
    );

    $v = Validator::make($new_data, $rules);

    if ($v->fails()) {
      return Redirect::to('account/profile')
              ->with('user', Auth::user())
              ->with_errors($v)
              ->with_input();
    }

    if ($dbUser = User::find($user->id)) {
      $dbUser->username = $new_data['username'];
      $dbUser->email = $new_data['email'];
      $dbUser->password = Hash::make($new_data['password']);
      $dbUser->save();
      return Redirect::to('account/profile')
               ->with('user', Auth::user())
               ->with('status', 'User updated');
    }


  }

  public function action_list() {
    $data = array(
      'users' => DB::table('users')->get(),
    );
    return View::make('account/list', $data);
  }
}
