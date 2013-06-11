<?php

class Permission extends Eloquent
{

  private $roles = array();
  private $myCaps = array();
  public $myRole;

  public function __construct($user) {
    if ($user) {
      $this->user = User::find($user->id);
      $this->loadCapabilities();
    }
  }

  private function loadCapabilities() {
    $this->myCaps = $this->user->caps();
    $this->myRole = $this->user->role()->name;
  }

  public function canI($function) {
    if ($this->myRole == 'admin') return true;

    foreach ($this->myCaps as $cap) {
      if ($cap->name == $function) {
        return true;
      }
    }

    return false;
  }

}
