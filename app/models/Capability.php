<?php
/**
 * Capabilitymodel
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


/**
 * Class Capability
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
