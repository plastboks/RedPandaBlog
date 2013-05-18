<?php

class Post extends Eloquent {
  
  public function author() {
    return $this->belongs_to('User', 'author_id');
  }

  public static function defaultRules(){
    return array(
      'title' => 'required|min:3|max:128',
      'body'  => 'required',
    );
  }

}
