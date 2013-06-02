<?php

class Category extends Eloquent
{
    public static $table = 'categories';
   
    public function posts()
    {
        return $this->has_many('Post');
    }

    public static function defaultRules()
    {
        return array(
            'title' => 'required|min:2|max:64',
            'slug'  => 'required|alpha_dash|min:2|max:32',
        );
    }
}

