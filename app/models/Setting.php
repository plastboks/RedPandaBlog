<?php
/**
 * SettingsModel
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
 * Class Setting
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
class Setting extends Eloquent
{

    /**
     * Database table
     *
     * @var string
     */
    protected $table = 'settings';

    /**
     * Default class variable
     *
     * @var string
     */
    public $blogName = 'Red Panda Blog';

    /**
     * Default class variable
     *
     * @var int
     */
    public $postsPerPage = 5;

    /**
     * Default class variable
     *
     * @var string
     */
    public $footer = 'Red Panda Awesome laravel blog';

    /**
     * Default class variable
     *
     * @var int
     */
    public $excerptCut = 400;

    /**
     * Load settings from database
     *
     * @param array $array settingsarray
     *
     * @return void
     */
    public function loadSettings($array = false)
    {
        if ($array) {
            foreach ($array as $obj) {
                $this->_setVar($obj['meta_key'], $obj['meta_value']);
            }
        }
    }

    /**
     * Get categories for use in selectors, included a default option
     *
     * @return array
     */
    public function getCatIncDefault()
    {
        $array = array();
        $array['all'] = '--All';

        $siteCat = $this->_getCategories();
        foreach ($siteCat as $cat) {
          $array[$cat->id] = $cat->slug;
        }
        return $array;
    }

    /**
     * Private method for getting site categories
     *
     * @return object
     */
    private function _getCategories()
    {
        return Category::all();
    }

    /**
     * Set var
     *
     * @param string $var   meta_key
     * @param string $value meta_value
     *
     * @return void
     */
    private function _setVar($var, $value)
    {
        $this->$var = $value;
    }

    /**
     * Default form rules
     *
     * @return array
     */
    public static function defaultRules()
    {
        return array(
            'blogName' => 'min:3|max:64',
            'footer' => 'max:64',
        );
    }

}

