<?php

class Permission extends Eloquent
{

  private $roles = array();
  private $myCaps = array();
  public $myRole;

  public function __construct($user) {
    $this->user = $user;
    $this->loadRoles();
    if ($user) {
      $this->loadCapabilities($user->role);
    } else {
      $this->myCaps = false;
    }
  }

  private function loadRoles() {
    $this->roles = array(
      1 => array('id' => 1, 'name' => 'admin'),
      2 => array('id' => 2, 'name' => 'publisher'),
      3 => array('id' => 3, 'name' => 'editor'),
    );
  }

  private function loadCapabilities($id) {
    $caps = array(
      $this->roles[1]['id'] => array(
                                  'everything',
                                ),
      $this->roles[2]['id'] => array(
                                  'createPost',
                                  'updatePost',
                                  'publishPost',
                                  'unpublishPost',
                                  'changePostState',
                                  'deletePost',
                                  'createCategory',
                                  'deleteCategory',
                                  'editCategory',
                                ),
      $this->roles[3]['id'] => array(
                                  'createPost',
                                  'createCategory',
                                ),
    );
    if ($this->user->id == 1) {
      $this->myCaps = $caps[1];
    } else {
      $this->myCaps = $caps[$id];
    }
    $this->myRole = $this->roles[$id]['name'];
  }

  public function canI($function) {
    if ((in_array($function, $this->myCaps)) ||
        (in_array('everything', $this->myCaps))) {
      return true;   
    }
    return false;
  }

  public function whatAreYou($id) {
    return $this->roles[$id]['name'];
  }
}
