<?php

class Category extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * Get this categorys posts
     *
     * @return string
     */
    public function posts()
    {
        return $this->belongsToMany('Post');
    }

    /**
     * Default form rule
     *
     * @return array
     */
    public static function defaultRules()
    {
        return array(
            'title' => 'required|min:2|max:64',
            'slug'  => 'required|alpha_dash|min:2|max:32',
        );
    }

}

