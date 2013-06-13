<?php 

class Account_Controller extends Base_Controller {
  
  public function __construct() {
    parent::__construct();
    $this->filter('before', 'auth');
  }

  public function action_index() {
    $this->filter('before', 'auth');
    return View::make('account/welcome');
  }

  public function action_profile() {
    $data = array(
      'user' => Auth::user(),
      'status' => Session::get('status'),
    );
    return View::make('account/profile', $data);
  }

  public function action_password() {
      $data = array(
        'error' => Session::get('error'),
        'status' => Session::get('status'),
      );
      return View::make('account/password', $data);
  }
  
  public function action_update() {
    $user = Auth::user();

    $v = Validator::make(Input::all(), User::defaultRules($user->id));

    if ($v->fails()) {
      return Redirect::to('account/profile')
              ->with('user', Auth::user())
              ->with_errors($v)
              ->with_input();
    }

    if ($dbUser = User::find($user->id)) {
      $dbUser->username = Input::get('username');
      $dbUser->email = Input::get('email');
      $dbUser->save();
      return Redirect::to('account/profile')
               ->with('user', Auth::user())
               ->with('status', 'User updated!');
    }
  }

  public function action_changepassword() {
    $user = User::find(Auth::user()->id);

    $v = Validator::make(Input::all(), User::passwordRules());

    if ($v->fails()) {
      return Redirect::to('account/password')
              ->with_errors($v)
              ->with_input();
    }

    if ($user) {
      if (Hash::check(Input::get('old_password'), $user->password)) {
        $user->password = Hash::make(Input::get('password'));
        $user->save();
        return Redirect::to('account/password')
                 ->with('status', 'Password changed');
      } else {
        return Redirect::to('account/password')
                ->with('error', 'Incorrect password');
      }
    }

    return Redirect::error(404);
  }


  public function action_myposts() {
    $user = User::find(Auth::user()->id);
    $data = array(
        'posts' => $user->posts()->paginate(10),
    );
    return View::make('account/myposts', $data);
  }

}
