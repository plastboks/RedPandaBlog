<?php

class Post extends Eloquent {
  
  public function author() {
    return $this->belongs_to('User', 'author_id');
  }

  public function categories()
  {
      return $this->has_many_and_belongs_to('Category');
  }

  public static function defaultRules(){
    return array(
      'title' => 'required|min:3|max:128',
      'body'  => 'required',
    );
  }

}
