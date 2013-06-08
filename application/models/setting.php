<?php

class Setting extends Eloquent {

  public $blogName = 'Red Panda Blog';
  public $postsPerPage = 5;
  public $footer = 'Red Panda Awesome laravel blog';

  public function loadSettings($array) {
    foreach((array)$array as $obj) {
      $this->setVar($obj->attributes['meta_key'] ,$obj->attributes['meta_value']);
    }
  }

  private function setVar($var, $value) {
    $this->$var = $value;
  }

  public static function defaultRules(){
    return array(
      'blogName' => 'min:3|max:64',
      'footer' => 'max:64',
    );
  }
}
