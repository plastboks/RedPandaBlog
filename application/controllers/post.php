<?php 

class Post_Controller extends Base_Controller {

  public function __construct() {
    parent::__construct();
    $this->filter('before', 'auth')->only('edit');
  }

  public function action_index() {
    $data = array(
      'posts' => Post::order_by('created_at', 'desc')
                  ->where('published', '=', 1)
                  ->paginate($this->s->postsPerPage),
      'errormessage' => false,
    );
    return View::make('frontpage', $data);
  }

  public function action_view($id) {
    $data = array (
      'post' => Post::find($id),
    );
    return View::make('post/view', $data);
  }

  public function action_q() {
    if (($q = Input::get('q')) && (strlen(Input::get('q')) > 3) ) {
      $data = array(
        'posts' => Post::order_by('updated_at', 'desc')
                    ->where('title', 'LIKE', "%$q%")
                    ->or_where('excerpt', 'LIKE', "%$q%")
                    ->or_where('body', 'LIKE', "%$q%")
                    ->paginate(4)
      );
      return View::make('post/searchresults', $data);
    } else {
      return Redirect::to('/')
                ->with('errormessage', 'Please enter 3 or more characters in search query');
    }
  }

  public function action_category($slug)
  {
      if ($cat = Category::where('slug', '=', $slug)->first()) {
        $data = array(
          'category' => $cat,
          'posts' => Category::find($cat->id)->posts()->paginate(4),
        );
        return View::make('post/category', $data);
      }
      return Redirect::to('/');
  }
}
