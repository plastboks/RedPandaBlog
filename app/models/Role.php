<?php
/**
 * RoleModel
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
 * Class Role
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
class Role extends Eloquent
{

    /**
     * Database table
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * Do not delete from database
     *
     * @var $softDelete
     */
    protected $softDelete = true;

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
