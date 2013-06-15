<?php

class Setting extends Eloquent
{

    /**
     * Default class variable
     *
     * @var string
     */
    public $blogName = 'Red Panda Blog';

    /**
     * Default class variable
     *
     * @var int
     */
    public $postsPerPage = 5;

    /**
     * Default class variable
     *
     * @var string
     */
    public $footer = 'Red Panda Awesome laravel blog';

    /**
     * Default class variable
     *
     * @var int
     */
    public $excerptCut = 400;

    /**
     * Load settings from database
     *
     * @param settings array
     *
     * @return void
     */
    public function loadSettings($array)
    {
        foreach((array)$array as $obj) {
            $this->setVar($obj->attributes['meta_key'] ,$obj->attributes['meta_value']);
        }
    }

    /**
     * Set var
     *
     * @return void
     */
    private function setVar($var, $value)
    {
        $this->$var = $value;
    }

    /**
     * Default form rules
     *
     * @return array
     */
    public static function defaultRules()
    {
        return array(
            'blogName' => 'min:3|max:64',
            'footer' => 'max:64',
        );
    }

}

