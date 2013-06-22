<?php
/**
 * Laravel Image Model
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
 * Class Image
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
class Image extends Eloquent
{

    /**
     * Database table
     *
     * @var string
     */
    protected $table = 'images';

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
    public function posts()
    {
        return $this->belongsToMany('Post');
    }

    /**
     * Image form default rules
     *
     * @return object
     */
    public static function defaultRules()
    {
        return array(
            'title'  => 'required|alpha_dash|min:2|max:32',
            'image' => 'image|max:3000',
        );
    }
}
