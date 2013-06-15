<?php 

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
        $this->filter('before', 'auth')->only('edit');
    }

    /**
     * Index view
     *
     * @return view
     */
    public function getIndex() 
    {
        $data = array(
            'posts' => Post::order_by('created_at', 'desc')
                              ->where('published', '=', 1)
                              ->paginate($this->s->postsPerPage),
            'errormessage' => false,
            'header' => 'Welcome !',
        );
        return View::make('index', $data);
    }

    /**
     * Post View
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
                $sql = Post::order_by('updated_at', 'desc')
                              ->where('title', 'LIKE', "%$q%")
                              ->or_where('excerpt', 'LIKE', "%$q%")
                              ->or_where('body', 'LIKE', "%$q%")
                              ->paginate($this->s->postsPerPage);
            } else {
                $sql = Post::order_by('updated_at', 'desc')
                              ->where('title', 'LIKE', "%$q%")
                              ->where('published', '=', 1)
                              ->or_where('excerpt', 'LIKE', "%$q%")
                              ->or_where('body', 'LIKE', "%$q%")
                              ->paginate($this->s->postsPerPage);
            }
            $data = array(
                'posts' => $sql,
                'errormessage' => false,
                'header' => 'Search results for; '.$q,
            );
            return View::make('index', $data);
        } else {
            return Redirect::to('/')
                                ->with('errormessage', 'Please enter 3 or more characters in search query');
        }
    }
 
    /**
     * Category search view
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

