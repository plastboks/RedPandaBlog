<?php

class Capability extends Eloquent
{
  
    public static $table = 'capabilities';

    public function roles()
    {
        return $this->has_many('Role');
    }


}
