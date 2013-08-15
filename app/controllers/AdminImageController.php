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
 * @link     http://github.com/plastboks/RedPandaBlog
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
 * @link     http://github.com/plastboks/RedPandaBlog
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
            'archived' => false,
        );
        return View::make('admin/image/list', $data);
    }

    /**
     * Image list
     *
     * @return view
     */
    public function getArchived()
    {
        if (!$this->p->canI('seeArchivedImages')) {
            return App::abort(403, 'Forbidden');
        }

        $data = array(
            'images' => Image::onlyTrashed()
                                  ->orderBy('created_at', 'desc')
                                  ->paginate(10),
            'archived' => true,
        );
        return View::make('admin/image/list', $data);
    }

    /**
     * Ajax image list
     *
     * @param int $postid Optional id for getting images in post
     *
     * @return view
     */
    public function ajaxEditList($postid)
    {
        $data = array(
            'images' => null,
            'postid' => null,
        );

        if (($post = Post::find($postid)) && (!Input::has('opposite'))) {
            $data['images'] = $post->images()->paginate(10);
            $data['postid'] = $postid;
        } else {
            $excludedIDs = array();
            foreach ($post->images()->get() as $img) {
                $excludedIDs[] = $img->id;
            }
            $data['images'] = Image::whereNotIn('id', $excludedIDs)->paginate(10);
        }

        return View::make('admin/image/ajaxlist', $data);
    }

    /**
     * Ajax list for new posts, for use in new post templates
     *
     * @param bool $images A boolean value for returning images or not
     *
     * @return view
     */
    public function ajaxNewList($images = false)
    {
        $data = array(
            'postid' => null,
            'images' => array(),
        );

        if ($images) {
            $data['images'] = Image::orderBy('created_at', 'desc')
                                      ->paginate(10);
        }
        return View::make('admin/image/ajaxlist', $data);
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
                      ->with('flashError', 'Unknown image');
        }

        $data = array(
            'image' => $image,
        );
        return View::make('admin/image/edit', $data);
    }

    /**
     * Delete image (archive)
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
                      ->with('flashError', 'Unknown image');
        }
        
        if (count($image->posts()->get())) {
            $errorMsg = 'You cannot delete an image that is connected to posts';
            return Redirect::back()
                      ->with('flashError', $errorMsg);
        }

        $image->delete();

        return Redirect::back()
                  ->with('flashStatus', 'Image '.$image->title.' deleted');
    }

    /**
     * Undelete image (restore)
     *
     * @param int $id image_id
     *
     * @return view
     */
    public function getUndelete($id)
    {
        if (!$this->p->canI('undeleteImage')) {
            return App::abort(403, 'Forbidden');
        }

        if (!$image = Image::onlyTrashed()->where('id', '=', $id)) {
            return Redirect::to('admin/image/archived')
                        ->with('flashError', 'Unknown image');
        }

        $image->restore();

        return Redirect::back()
                  ->with('flashStatus', 'Image restored');

    }

    /**
     * Forcedelete image
     *
     * @param int $id image_id
     *
     * @return view
     */
    public function getTrueDelete($id)
    {
        if (!$this->p->canI('trueDeleteImage')) {
            return App::abort(403, 'Forbidden');
        }

        if (!$image = Image::onlyTrashed()->where('id', '=', $id)) {
            return Redirect::to('admin/image/archived')
                      ->with('flashError', 'Unkown image');
        }

        $image->forceDelete();
        
        return Redirect::back()
                    ->with('flashStatus', 'Image is permanently deleted');
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
        $image->uploader_id = Auth::user()->id;
        $image->filename = $newFilename;

        $image->save();
         
        return Redirect::to('admin/image/list')
                  ->with('flashSuccess', 'New image '.$image->title.' created');
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
                      ->with('flashStatus', 'Image '.$image->title.' updated');
        }

        return Redirect::back()
                  ->with('flashError', 'Unknown image');
    }

}

