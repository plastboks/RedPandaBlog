<?php

class User extends Eloquent {
  
  public static $table = 'users';

  public function posts() {
    return $this->has_many('Post', 'id');
  }

  public function role() {
    $role = Role::find($this->role_id);
    return $role;
  }

  public function caps() {
    return $this->role()->capabilities()->get();
  }

  public static function defaultRules($selfID = false) {
    if ($selfID) {
      return array(
        'username' => "required|min:3|max:32|unique:users,username,{$selfID}",
        'email'  => "required|email|max:64|unique:users,email,{$selfID}",
        'password' => 'confirmed|min:6|max:64',
      );
    } else {
      return array(
        'username' => "required|min:3|max:32|unique:users,username",
        'email'  => "required|email|max:64|unique:users,email",
        'password' => 'required|confirmed|min:6|max:64',
      );
    }
  }

}
