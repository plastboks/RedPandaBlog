<?php 

class Role extends Eloquent
{

    public static $table = 'roles';

    public function users() {
        return $this->has_many('User', 'role_id');
    }

    public function capabilities()
    {
        return $this->has_many_and_belongs_to('Capability');
    }

    public static function defaultRules()
    {
        return array(
            'name'  => 'required|alpha_dash|min:2|max:16',
        );
    }

}
