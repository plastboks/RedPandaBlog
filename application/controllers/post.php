<?php 

class Post_Controller extends Base_Controller {

  public function __construct() {
    $this->filter('before', 'auth')->only('edit');
  }

  public function action_index() {
    return View::make('post/index');
  }

  public function action_view($id) {
    $data = array (
      'post' => Post::find($id),
    );
    return View::make('post/view', $data);
  }

}
