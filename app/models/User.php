<?php
/**
 * UserModel
 *
 * PHP version 5.4
 *
 * @category Development
 * @package  BaseController
 * @author   Alexander Skjolden <alex@plastboks.net>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License
 *
 * @link     http://github.com/plastboks/red-panda-blog
 * @date     2013-06-17
 *
 */


use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

/**
 * Class User
 *
 * @category Development
 * @package  BaseController
 * @author   Alexander Skjolden <alex@plastboks.net>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License
 *
 * @link     http://github.com/plastboks/red-panda-blog
 * @date     2013-06-17
 *
 */
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
     * Do not delete from database
     *
     * @var $softDelete
     */
    protected $softDelete = true;

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
        return $this->hasMany('Post', 'author_id');
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
     * @param int $id user_id
     *
     * @return array
     */
    public static function defaultRules($id = false)
    {
        if ($id) {
            return array(
                'username' => "required|min:3|max:32|unique:users,username,{$id}",
                'email'    => "required|email|max:64|unique:users,email,{$id}",
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

