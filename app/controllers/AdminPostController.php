<?php
/**
 * File: AdminPostController
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
 * Class AdminPostController
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
class AdminPostController extends BaseController
{
    
    /**
     * Sets permisssions and loads parent construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->beforeFilter('auth');
    }

    /**
     * Post list (published)
     *
     * @return view
     */
    public function getList()
    {
        $data = array(
            'posts' => Post::orderBy('created_at', 'desc')
                                ->where('published', '=', '1')
                                ->paginate(10),
            'title' => 'Published posts',
            'action' => 'unpublish',
        );
        return View::make('admin/post/list', $data);
    }

    /**
     * Post unpublished
     *
     * @return view
     */
    public function getUnpublished()
    {
        $data = array(
            'posts' => Post::orderBy('created_at', 'desc')
                                ->whereNull('published')
                                ->paginate(10),
            'title' => 'Unpublished posts',
            'action' => 'publish',
        );
        return View::make('admin/post/list', $data);
    }

    /**
     * New post view
     *
     * @return view
     */
    public function getNew()
    {
        if (!$this->p->canI('createPost')) {
            return App::abort(403, 'Forbidden');
        }

        $data = array(
            'user' => Auth::user(),
            'categories' => Category::all(),
        );
        return View::make('admin/post/new', $data);
    }

    /**
     * Post edit view
     *
     * @param int $id post_id
     *
     * @return view
     */
    public function getEdit($id)
    {
        if (!$this->p->canI('updatePost')) {
            return App::abort(403, 'Forbidden');
        }

        $data = array(
            'post' => Post::find($id),
            'user' => Auth::user(),
            'categories' => Category::all(),
            'images' => Post::find($id)->images()->get(),
        );
        return View::make('admin/post/edit', $data);
    }

    /**
     * Publish post action
     *
     * @param int $id post_id
     *
     * @return redirect
     */
    public function getPublish($id)
    {
        if (($this->p->canI('publishPost'))
            && ($post = Post::find($id))
        ) {

            $post->published = 1;
            $post->save();
        }
        return Redirect::to('admin/post/unpublished');
    }

    /**
     * Unpublish post action
     *
     * @param int $id post_id
     *
     * @return redirect
     */
    public function getUnpublish($id)
    {
        if (($this->p->canI('unpublishPost'))
            && ($post = Post::find($id))
        ) {

            $post->published = null;
            $post->save();
        }
        return Redirect::to('admin/post/list');
    }

    /**
     * Delete post action
     *
     * @param int $id category_id
     *
     * @return redirect
     */
    public function getDelete($id)
    {
        if (($this->p->canI('deletePost'))
            && ($post = Post::find($id))
        ) {

            if (count($post->categories()->get())) {
                $post->categories()->detach();
            }
            $post->delete();
            return Redirect::to('admin/post/list');
        }

        return Redirect::to('admin/post/list');
    }

    /**
     * Create post action
     *
     * @return redirect
     */
    public function postCreate()
    {
        if (!$this->p->canI('createPost')) {
            return App::abort(403, 'Forbidden');
        }

        $v = Validator::make(Input::all(), Post::defaultRules());

        if ($v->fails()) {
            return Redirect::back()
                      ->with('user', Auth::user())
                      ->withErrors($v)
                      ->withInput();
        }

        $post = new Post();
        $post->title = Input::get('title');
        $post->excerpt = Input::get('excerpt');
        $post->body = Input::get('body');
        $post->author_id = Input::get('author_id');

        if ($this->p->canI('publishPost')) {
            $post->published = Input::get('published');
        }

        $post->save();

        if (Input::get('category')) {
            $post->categories()->sync(Input::get('category'));
        }

        if (Input::has('image')) {
            foreach (Input::get('image') as $img) {
                $post->images()->attach($img, array(
                       'placement' => Input::get('placement')[$img],
                ));
            }
        }

        return Redirect::to('post/view/'.$post->id);
    }

    /**
     * Update post action
     *
     * @param int $id post_id
     *
     * @return view
     */
    public function postUpdate($id)
    {
        if (!$this->p->canI('updatePost')) {
            return App::abort(403, 'Forbidden');
        }

        $v = Validator::make(Input::all(), Post::defaultRules());

        if ($v->fails()) {
            return Redirect::back()
                      ->with('user', Auth::user())
                      ->withErrors($v)
                      ->withInput();
        }

        if ($post = Post::find($id)) {
            $post->title = Input::get('title');
            $post->excerpt = Input::get('excerpt');
            $post->body = Input::get('body');
            $post->author_id = Input::get('author_id');

            if ($this->p->canI('publishPost')) {
                $post->published = Input::get('published');
            }

            if (Input::has('category')) {
                $post->categories()->sync(Input::get('category'));
            } else {
                $post->categories()->detach();
            }

            if (Input::has('image')) {
                $post->images()->detach();
                foreach (Input::get('image') as $img) {
                  $post->images()->attach($img, array(
                           'placement' => Input::get('placement')[$img],
                           ));
                }
            } else {
                $post->images()->detach();
            }

            $post->save();
            return Redirect::to('post/view/'.$id);
        }

    }

}

