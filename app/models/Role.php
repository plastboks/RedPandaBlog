<?php

class Role extends Eloquent
{

    /**
     * Database table
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * Get role users
     *
     * @return object
     */
    public function users()
    {
        return $this->hasMany('User', 'role_id');
    }

    /**
     * Get role capabilites
     *
     * @return object
     */
    public function capabilities()
    {
        return $this->belongsToMany('Capability');
    }

    /**
     * Role form default rules
     *
     * @return object
     */
    public static function defaultRules()
    {
        return array(
            'name'  => 'required|alpha_dash|min:2|max:16',
        );
    }

}
