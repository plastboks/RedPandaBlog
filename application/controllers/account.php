<?php 

class Account_Controller extends Base_Controller {
  
  public function __construct() {
    $this->filter('before', 'auth');
  }

  public function action_index() {
    print("this is the profile page %s %s");
  }

  public function action_welcome() {
    $this->filter('before', 'auth');
    return View::make('account/welcome');
  }

  public function action_list() {
    
    $data = array(
      'users' => DB::table('users')->get(),
    );
    
    return View::make('account/list', $data);
  }
}
