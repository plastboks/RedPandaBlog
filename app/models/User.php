<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    /**
     * Get the users posts
     *
     * @return string
     */
    public function posts()
    {
        return $this->hasMany('Post', 'id');
    }

    /**
     * Get the users role
     *
     * @return string
     */
    public function role()
    {
        return Role::find($this->role_id);
    }

    /**
     * Get the users capabilities
     *
     * @return string
     */
    public function caps()
    {
        return $this->role()->capabilities()->get();
    }

    /**
     * Default form rule
     *
     * @return array
     */
    public static function defaultRules($selfID = false)
    {
        if ($selfID) {
            return array(
                'username' => "required|min:3|max:32|unique:users,username,{$selfID}",
                'email'    => "required|email|max:64|unique:users,email,{$selfID}",
                'givenname' => 'max:32',
                'surname' => 'max:48',
                'info' => 'max:512',
                'password' => 'confirmed|min:6|max:64',
            );
        } else {
            return array(
                'username' => "required|min:3|max:32|unique:users,username",
                'email'    => "required|email|max:64|unique:users,email",
                'givenname' => 'max:32',
                'surname' => 'max:48',
                'info' => 'max:512',
                'password' => 'required|confirmed|min:6|max:64',
            );
        }
    }

    /**
     * Password form rules
     *
     * @return array
     */
    public static function passwordRules()
    {
        return array(
                'password' => 'required|confirmed|min:6|max:64',
        );
    }

    /**
     * Forgot password rules
     *
     * @return array
     */
    public static function forgotPassword()
    {
        return array(
            'email' => 'required|email',
        );
    }

}

