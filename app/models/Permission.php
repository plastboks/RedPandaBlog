<?php
/**
 * PermissionModel
 *
 * PHP version 5.4
 *
 * @category Development
 * @package  BaseController
 * @author   Alexander Skjolden <alex@plastboks.net>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License
 *
 * @link     http://github.com/plastboks/RedPandaBlog
 * @date     2013-06-17
 *
 */


/**
 * Class Permission
 *
 * @category Development
 * @package  BaseController
 * @author   Alexander Skjolden <alex@plastboks.net>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License
 *
 * @link     http://github.com/plastboks/RedPandaBlog
 * @date     2013-06-17
 *
 */
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
     * @param int $user user_id
     *
     * @return void
     */
    public function __construct($user)
    {
        if ($user) {
            $this->user = User::find($user->id);
            $this->_loadCapabilities();
        }
    }

    /**
     * Load capabilites method
     *
     * @return void
     */
    private function _loadCapabilities()
    {
        $this->myCaps = $this->user->caps();
        $this->myRole = $this->user->role()->name;
    }

    /**
     * Default form rule
     *
     * @param string $function function string
     *
     * @usage `canI('editPosts)`
     *
     * @return array
     */
    public function canI($function)
    {
        if ($this->myRole == 'admin') {
            return true;
        }

        foreach ($this->myCaps as $cap) {
            if ($cap->name == $function) {
                return true;
            }
        }
        return false;
    }

}

