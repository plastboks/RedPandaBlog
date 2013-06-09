<?php

class Admin_User_Controller extends Base_Controller {

  public function __construct() {
    $this->filter('before', 'auth');
  }

  public function action_list() {
    $data = array(
      'myself' => Auth::user(),
      'users' => User::order_by('id', 'asc')
                        ->where_null('blocked')
                        ->paginate(10),
      'status' => Session::get('status'),
      'title' => 'Active users',
      'action' => 'block',
    );
    return View::make('admin/user/list', $data);
  }

  public function action_blocked() {
    $data = array(
      'myself' => Auth::user(),
      'users' => User::order_by('id', 'asc')
                        ->where('blocked', '=', '1')
                        ->paginate(10),
      'status' => Session::get('status'),
      'title' => 'Blocked users',
      'action' => 'unblock',
    );
    return View::make('admin/user/list', $data);
  }
 
  public function action_edit($id) {
    $myself = Auth::user();

    if ($myself->id == $id) {
      return Redirect::to('account/profile');
    } elseif ($user = User::find($id)) {
      $data = array(
        'user' => $user,
        'status' => Session::get('status'),
      );
      return View::make('admin/user/edit', $data);
    }
    return Redirect::to('admin/users');
  }

  public function action_new() {
    $data = array(
      'status' => Session::get('status'),
      'username' => Session::get('username'),
      'email' => Session::get('email'),
    );
    return View::make('admin/user/new', $data);
  }

  public function action_create() {
    $v = Validator::make(Input::all(), User::defaultRules());

    if ($v->fails()) {
      return Redirect::to('admin/user/new')
              ->with_errors($v)
              ->with('username', Input::get('username'))
              ->with('email', Input::get('email'))
              ->with_input();
    }

    $user = new User();
    $user->username = Input::get('username');
    $user->email = Input::get('email');
    $user->password = Hash::make(Input::get('password'));
    $user->save();
    return Redirect::to('admin/user/list')
            ->with('status', 'New user created');
  }

  public function action_update($id) {
    $v = Validator::make(Input::all(), User::defaultRules($id));

    if ($v->fails()) {
      return Redirect::to('admin/user/edit/'.$id)
              ->with_errors($v);
    }
  
    if ($user = User::find($id)) {
      $user->username = Input::get('username');
      $user->email = Input::get('email');
      $user->password = Hash::make(Input::get('password'));
      $user->save();
      return Redirect::to('admin/user/list')
              ->with('status', "User updated");
    }
  }
  
  public function action_block($id) {
    if ($user = User::find($id)) {
      $user->blocked = 1;
      $user->save();
    }
    return Redirect::to('admin/user/list');
  }

  public function action_unblock($id) {
    if ($user = User::find($id)) {
      $user->blocked = NULL;
      $user->save();
    }
    return Redirect::to('admin/user/blocked');
  }

  public function action_delete($id) {
    if (($id != Auth::user()->id) && ($user = User::find($id))) {
      $user->delete();
    }
    return Redirect::to('admin/user/list');
  }

}
