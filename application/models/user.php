<?php

class User extends Eloquent {
  
  public static $table = 'users';

  public function posts() {
    return $this->has_many('Post');
  }

}
