<?php
/**
 * PostModel
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
 * Class Post
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
class Post extends Eloquent
{

    /**
     * Database table
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * Do not delete from database
     *
     * @var $softDelete
     */
    protected $softDelete = true;

    /**
     * Get post author
     *
     * @return object
     */
    public function author()
    {
        return $this->belongsTo('User', 'author_id');
    }

    /**
     * Get post categories
     *
     * @return object
     */
    public function categories()
    {
        return $this->belongsToMany('Category');
    }

    /**
     * Get post images
     *
     * @return object
     */
    public function images()
    {
        return $this->belongsToMany('Image')->withPivot('placement');
    }

    /**
     * Default form rules
     *
     * @return array
     */
    public static function defaultRules()
    {
        return array(
            'title' => 'required|min:3|max:128',
            'body'    => 'required',
        );
    }

}

