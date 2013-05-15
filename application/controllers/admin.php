<?php 

class Admin_Controller extends Base_Controller {
  
  public function __construct() {
    $this->filter('before', 'auth');
  }

  public function action_index() {
    return View::make('admin/index');
  }

  public function action_newpost() {
    return View::make('admin/newpost');
  }

}
