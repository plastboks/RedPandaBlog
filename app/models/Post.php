<?php

class Post extends Eloquent 
{
    
    /**
     * Get post author
     *
     * @return object
     */
    public function author()
    {
        return $this->belongsTo('User', 'author_id');
    }

    /**
     * Get post categories
     *
     * @return object
     */
    public function categories()
    {
        return $this->hasManyAndBelongsTo('Category');
    }

    /**
     * Default form rules
     *
     * @return array
     */
    public static function defaultRules()
    {
        return array(
            'title' => 'required|min:3|max:128',
            'body'    => 'required',
        );
    }

}

