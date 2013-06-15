<?php

class Capability extends Eloquent
{
  
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'capabilities';

    /**
     * Get this capabilities roles
     *
     * @return string
     */
    public function roles()
    {
        return $this->hasMany('Role');
    }


}
