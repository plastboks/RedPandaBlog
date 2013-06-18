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
 * @link     http://github.com/plastboks/red-panda-blog
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
 * @link     http://github.com/plastboks/red-panda-blog
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

