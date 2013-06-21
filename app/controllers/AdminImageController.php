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
            'status' => Session::get('status'),
            'error' => Session::get('error'),
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
     * @param int $id image_id
     *
     * @return view
     */
    public function getEdit($id)
    {
        if (!$this->p->canI('editImage')) {
            return App::abort(403, 'Forbidden');
        }

        if (!$image = Image::find($id)) {
            return Redirect::to('admin/image/list')
                      ->with('error', 'Unknown image');
        }

        $data = array(
            'image' => $image,
        );
        return View::make('admin/image/edit', $data);
    }

    /**
     * Post update image
     *
     * @param int $id image_id
     *
     * @return view
     */
    public function getDelete($id)
    {
        if (!$this->p->canI('deleteImage')) {
            return App::abort(403, 'Forbidden');
        }

        if (!$image = Image::find($id)) {
            return Redirect::to('admin/image/list')
                      ->with('error', 'Unknown image');
        }
        
        if (count($image->posts()->get())) {
            $errorMsg = 'You cannot delete an image that is connected to posts';
            return Redirect::back()
                      ->with('error', $errorMsg);
        }

        $image->delete();

        return Redirect::back()
                  ->with('status', 'Image '.$image->title.' deleted');
    }

    /**
     * Post create image
     *
     * @return view
     */
    public function postCreate()
    {
        if (!$this->p->canI('createImage')) {
            return App::abort(403, 'Forbidden');
        }

        $v = Validator::make(Input::all(), Image::defaultRules());

        if ($v->fails()) {
            return Redirect::back()
                      ->withErrors($v)
                      ->withInput();
        }

        $file = Input::file('image');
        $filename = $file->getClientOriginalName();
        $newFilename = str_random(8).'-'.$filename;

        $file->move('uploads/', $newFilename);

        $image = new Image;
        $image->title = Input::get('title');
        $image->uploader = Auth::user()->id;
        $image->filename = $newFilename;

        $image->save();
         
        return Redirect::to('admin/image/list')
                  ->with('status', 'New image '.$image->title.' created');
    }

    /**
     * Post update image
     *
     * @param int $id image_id
     *
     * @return view
     */
    public function postUpdate($id)
    {
        if (!$this->p->canI('editImage')) {
            return App::abort(403, 'Forbidden');
        }

        $v = Validator::make(Input::all(), Image::defaultRules());

        if ($v->fails()) {
            return Redirect::back()
                      ->withErrors($v)
                      ->withInput();
        }
        
        if ($image = Image::find($id)) {
            $image->title = Input::get('title');
            $image->save();
            
            return Redirect::to('admin/image/list')
                      ->with('status', 'Image '.$image->title.' updated');
        }

        return Redirect::back()
                  ->with('error', 'Unknown image');
    }

}

