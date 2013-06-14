<?php

class Admin_User_Controller extends Base_Controller {

  public function __construct() {
    parent::__construct();
    $this->filter('before', array('auth'));
  }

  public function action_list() {
    if (!$this->p->canI('seeUsers')) return Redirect::error(403);
      
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
    if (!$this->p->canI('seeUsers')) return Redirect::error(403);

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
    if (!$this->p->canI('updateUser')) return Redirect::error(403);

    if ($id == 1) return Redirect::error(403);
    $myself = Auth::user();
    $formRoles = array();
    foreach ((array)Role::all() as $role) {
      $formRoles[$role->id] = ucwords($role->name);
    } 

    if ($myself->id == $id) {
      return Redirect::to('account/profile');
    } elseif ($user = User::find($id)) {
      $data = array(
        'user' => $user,
        'status' => Session::get('status'),
        'roles' => $formRoles,
      );
      return View::make('admin/user/edit', $data);
    }
    return Redirect::to('admin/users');
  }

  public function action_new() {
    if (!$this->p->canI('createUser')) return Redirect::error(403);

    $formRoles = array();
    foreach ((array)Role::all() as $role) {
      $formRoles[$role->id] = ucwords($role->name);
    }
    $data = array(
      'status' => Session::get('status'),
      'username' => Session::get('username'),
      'email' => Session::get('email'),
      'roles' => $formRoles,
    );
    return View::make('admin/user/new', $data);
  }

  public function action_create() {
    if (!$this->p->canI('createUser')) return Redirect::error(403);

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
    $user->givenname = Input::get('givenname');
    $user->surname = Input::get('surname');
    $user->info = Input::get('info');
    $user->role_id = Input::get('role');
    $user->password = Hash::make(Input::get('password'));
    $user->save();
    return Redirect::to('admin/user/list')
            ->with('status', 'New user created');
  }

  public function action_update($id) {
    if (!$this->p->canI('updateUser')) return Redirect::error(403);
    if ($id == 1) return Redirect::error(403);

    $v = Validator::make(Input::all(), User::defaultRules($id));

    if ($v->fails()) {
      return Redirect::to('admin/user/edit/'.$id)
              ->with_errors($v);
    }
  
    if ($user = User::find($id)) {
      $user->username = Input::get('username');
      $user->email = Input::get('email');
      $user->givenname = Input::get('givenname');
      $user->surname = Input::get('surname');
      $user->info = Input::get('info');
      $user->role_id = Input::get('role');
      if (Input::get('password')) {
        $user->password = Hash::make(Input::get('password'));
      }
      $user->save();
      return Redirect::to('admin/user/list')
              ->with('status', "User updated");
    }
  }
  
  public function action_block($id) {
    if (!$this->p->canI('blockUser')) return Redirect::error(403);
    if ($id == 1) return Redirect::error(403);

    if ($user = User::find($id)) {
      $user->blocked = 1;
      $user->save();
    }
    return Redirect::to('admin/user/list');
  }

  public function action_unblock($id) {
    if (!$this->p->canI('unblockUser')) return Redirect::error(403);

    if ($user = User::find($id)) {
      $user->blocked = NULL;
      $user->save();
    }
    return Redirect::to('admin/user/blocked');
  }

  public function action_delete($id) {
    if (!$this->p->canI('deleteUser')) return Redirect::error(403);
    if ($id == 1) return Redirect::error(403);

    if (($id != Auth::user()->id) && ($user = User::find($id))) {
      if (!count($user->posts()->get())) {
        $user->delete();
      }
    }
    return Redirect::to('admin/user/list');
  }

}
