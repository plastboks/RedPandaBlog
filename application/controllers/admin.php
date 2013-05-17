<?php 

class Admin_Controller extends Base_Controller {
  
  public function __construct() {
    $this->filter('before', 'auth');
  }

  public function action_index() {
    $data = array(
      'posts' => Post::all(),
    );
    return View::make('admin/index', $data);
  }

  public function action_users() {
    $data = array(
      'users' => DB::table('users')->get(),
      'status' => Session::get('status'),
    );
    return View::make('admin/users', $data);
  }

  public function action_edituser($id) {
    $myself = Auth::user();

    if ($myself->id == $id) {
      return Redirect::to('account/profile');
    } elseif ($user = User::find($id)) {
      $data = array(
        'user' => $user,
        'status' => Session::get('status'),
      );
      return View::make('admin/edituser', $data);
    }
    return Redirect::to('admin/users');
  }
 
  public function action_newuser() {
    $data = array(
      'status' => Session::get('status'),
      'username' => Session::get('username'),
      'email' => Session::get('email'),
    );
    return View::make('admin/newuser', $data);
  }

  public function action_createuser() {
    $v = Validator::make(Input::all(), User::defaultRules());

    if ($v->fails()) {
      return Redirect::to('admin/newuser')
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
    return Redirect::to('admin/users')
            ->with('status', 'New user created');
  }

  public function action_updateuser($id) {
    $v = Validator::make(Input::all(), User::defaultRules($id));

    if ($v->fails()) {
      return Redirect::to('admin/edituser/'.$id)
              ->with_errors($v);
    }
  
    if ($user = User::find($id)) {
      $user->username = Input::get('username');
      $user->email = Input::get('email');
      $user->password = Hash::make(Input::get('password'));
      $user->save();
      return Redirect::to('admin/users')
              ->with('status', "User updated");
    }
  }

  public function action_posts() {
    $data = array(
      'posts' => Post::all(),
    );
    return View::make('admin/posts', $data);
  }

  public function action_newpost() {
    $data = array(
      'user' => Auth::user(),
    );
    return View::make('admin/newpost', $data);
  }

  public function action_createpost() {
    $new_post = array(
      'title'     => Input::get('title'),
      'body'      => Input::get('body'),
      'author_id' => Input::get('author_id'),
    );

    $rules = array(
      'title' => 'required|min:3|max:128',
      'body'  => 'required',
    );

    $v = Validator::make($new_post, $rules);

    if ($v->fails()) {
      return Redirect::to('admin/newpost')
              ->with('user', Auth::user())
              ->with_errors($v)
              ->with_input();
    }

    $post = new Post($new_post);
    $post->save();

    return Redirect::to('post/view/'.$post->id);
  }

  public function action_updatepost($id) {
    $edit_post = array(
      'title' => Input::get('title'),
      'body' => Input::get('body'),
      'author_id' => Input::get('author_id'),
    );

    $rules = array(
      'title' => 'required|min:3|max:128',
      'body'  => 'required',
    );

    $v = Validator::make($edit_post, $rules);

    if ($v->fails()) {
      return Redirect::to('post/edit/'.$id)
              ->with('user', Auth::user())
              ->with_errors($v)
              ->with_input();
    }

    if ($post = Post::find($id)) {
      $post->title = $edit_post['title'];
      $post->body = $edit_post['body'];
      $post->author_id = $edit_post['author_id'];
      $post->save();
      return Redirect::to('post/view/'.$id);
    }
  }
}
