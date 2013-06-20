<?php
/**
 * File: AdminImageController.php
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
 * Class AdminImageController
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
class AdminImageController extends BaseController
{

    /**
     * Sets permisssions and loads parent construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        Route::filter('before', array('auth'));
    }

    /**
     * Image list
     *
     * @return view
     */
    public function getList()
    {
        $data = array(
            'images' => Image::orderBy('created_at', 'desc')
                                ->paginate(10),
        );
        return View::make('admin/image/list', $data);
    }
    
    /**
     * New image
     *
     * @return view
     */
    public function getNew()
    {
        return View::make('admin/image/new');
    }

    /**
     * Edit image
     *
     * @return view
     */
    public function getEdit()
    {
        return View::make('admin/image/edit');
    }

    /**
     * Post create image
     *
     * @return view
     */
    public function postCreate()
    {
        return Redirect::back();
    }

    /**
     * Post update image
     *
     * @return view
     */
    public function postUpdate()
    {
        return Redirect::back();
    }
}

