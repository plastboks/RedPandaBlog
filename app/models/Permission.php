<?php

class Permission extends Eloquent
{

    /**
     * Class roles
     *
     * @var array
     */
    protected $roles = array();

    /**
     * Class Capabilites
     *
     * @var array
     */
    protected $myCaps = array();

    /**
     * Class role
     *
     * @var string
     */
    public $myRole;

    /**
     * Class construct
     *
     * @return void
     */
    public function __construct($user)
    {
        if ($user) {
            $this->user = User::find($user->id);
            $this->loadCapabilities();
        }
    }

    /**
     * Load capabilites method
     *
     * @return void
     */
    private function loadCapabilities() {
        $this->myCaps = $this->user->caps();
        $this->myRole = $this->user->role()->name;
    }

    /**
     * Default form rule
     *
     * @return array
     */
    public function canI($function) {
        if ($this->myRole == 'admin') return true;

        foreach ($this->myCaps as $cap) {
            if ($cap->name == $function) {
                return true;
            }
        }
        return false;
    }

}

