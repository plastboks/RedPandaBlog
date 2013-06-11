<?php

class Capability extends Eloquent
{
  
    public static $table = 'capabilites';

    public function roles()
    {
        return $this->has_many('Role');
    }


}
