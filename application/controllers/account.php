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
      if (Input::get('password')) {
        $dbUser->password = Hash::make(Input::get('password'));
      }
      $dbUser->save();
      return Redirect::to('account/profile')
               ->with('user', Auth::user())
               ->with('status', 'User updated!');
    }
  }

  public function action_myposts() {
    $user = Auth::user();
    $data = array(
      'posts' => Post::order_by('created_at', 'desc')
                  ->where('author_id', '=', $user->id)
                  ->paginate($this->s->postsPerPage),
    );
    return View::make('account/myposts', $data);
  }

}
