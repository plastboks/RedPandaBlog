<?php
/**
 * CategoryModel
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
 * Class Category
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
class Category extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * Do not delete from database
     *
     * @var $softDelete
     */
    protected $softDelete = true;

    /**
     * Get this categorys posts
     *
     * @return string
     */
    public function posts()
    {
        return $this->belongsToMany('Post');
    }

    /**
     * Default form rule
     *
     * @return array
     */
    public static function defaultRules()
    {
        return array(
            'title' => 'required|min:2|max:64',
            'slug'  => 'required|alpha_dash|min:2|max:32|unique:categories,slug',
        );
    }

}

