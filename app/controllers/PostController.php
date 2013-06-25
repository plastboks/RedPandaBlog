<?php
/**
 * File: PostController
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
 * Class PostController
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

class PostController extends BaseController
{

    /**
     * Sets permissions and load parents construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Index view
     *
     * @return view
     */
    public function getIndex()
    {
        $d = 'Welcome !';
        $header = count(Post::where('published', '=', 1)->take(1)->get()) ? null:$d;
        $data = array(
            'errormessage' => Session::get('error'),
            'header' => $header,
        );

        if (($this->s->frontpagecategory)
            && ($this->s->frontpagecategory != 'all')
        ) {
            $data['posts'] = Category::find((int)$this->s->frontpagecategory)
                                ->posts()
                                ->where('published', '=', 1)
                                ->paginate($this->s->postsPerPage);
        } else {
            $data['posts'] = Post::orderBy('created_at', 'desc')
                                ->where('published', '=', 1)
                                ->paginate($this->s->postsPerPage);
        }
        return View::make('index', $data);
    }

    /**
     * Post View
     *
     * @param int $id post_id
     *
     * @return view
     */
    public function getView($id)
    {
        $data = array (
            'post' => Post::find($id),
        );
        return View::make('post/view', $data);
    }

    /**
     * Post search view
     *
     * @return view
     */
    public function getQ()
    {
        if (($q = Input::get('q')) && (strlen(Input::get('q')) > 3)) {
            if (!Auth::guest()) {
                $sql = Post::orderBy('updated_at', 'desc')
                              ->where('title', 'LIKE', "%$q%")
                              ->orWhere('excerpt', 'LIKE', "%$q%")
                              ->orWhere('body', 'LIKE', "%$q%")
                              ->paginate($this->s->postsPerPage);
            } else {
                $sql = Post::orderBy('updated_at', 'desc')
                              ->where('title', 'LIKE', "%$q%")
                              ->where('published', '=', 1)
                              ->orWhere('excerpt', 'LIKE', "%$q%")
                              ->orWhere('body', 'LIKE', "%$q%")
                              ->paginate($this->s->postsPerPage);
            }
            $data = array(
                'posts' => $sql,
                'errormessage' => false,
                'header' => 'Search results for; '.$q,
            );
            return View::make('index', $data);
        } else {
            $message = 'Please enter 3 og more character in the search query';
            return Redirect::to('/')
                      ->with('errormessage', $message);
        }
    }

    /**
     * Category search view
     *
     * @param string $slug post slug
     *
     * @return view
     */
    public function getCategory($slug)
    {
        if ($cat = Category::where('slug', '=', $slug)->first()) {
            if (!Auth::guest()) {
                $sql = Category::find($cat->id)
                          ->posts()
                          ->paginate($this->s->postsPerPage);
            } else {
                $sql = Category::find($cat->id)
                          ->posts()
                          ->where('published', '=', 1)
                          ->paginate($this->s->postsPerPage);
            }
            $data = array(
                'posts' => $sql,
                'errormessage' => false,
                'header' => 'Posts in category; '.$slug,
            );
            return View::make('index', $data);
        }
        return Redirect::to('/');
    }

}

