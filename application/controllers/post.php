<?php 

class Post_Controller extends Base_Controller {

  public function __construct() {
    parent::__construct();
    $this->filter('before', 'auth')->only('edit');
  }

  public function action_index() 
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

  public function action_view($id) 
  {
    $data = array (
      'post' => Post::find($id),
    );
    return View::make('post/view', $data);
  }

  public function action_q() 
  {
    if (($q = Input::get('q')) && (strlen(Input::get('q')) > 3) ) {
      $data = array(
        'posts' => Post::order_by('updated_at', 'desc')
                    ->where('title', 'LIKE', "%$q%")
                    ->or_where('excerpt', 'LIKE', "%$q%")
                    ->or_where('body', 'LIKE', "%$q%")
                    ->paginate($this->s->postsPerPage),
        'errormessage' => false,
        'header' => 'Search results for; '.$q,
      );
      return View::make('index', $data);
    } else {
      return Redirect::to('/')
                ->with('errormessage', 'Please enter 3 or more characters in search query');
    }
  }

  public function action_category($slug)
  {
      if ($cat = Category::where('slug', '=', $slug)->first()) {
        $data = array(
          'posts' => Category::find($cat->id)
                      ->posts()
                      ->paginate($this->s->postsPerPage),
          'errormessage' => false,
          'header' => 'Posts in category; '.$slug,
        );
        return View::make('index', $data);
      }
      return Redirect::to('/');
  }
}
