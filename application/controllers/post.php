<?php 

class Post_Controller extends Base_Controller {

  public function __construct() {
    $this->filter('before', 'auth')->only('edit');
  }

  public function action_index() {
    return View::make('post/index');
  }

  public function action_view($id) {
    $data = array (
      'post' => Post::find($id),
    );
    return View::make('post/view', $data);
  }

  public function action_q() {
    $q = Input::get('q');
    $data = array(
      'posts' => Post::order_by('updated_at', 'desc')
                  ->where('title', 'LIKE', "%$q%")
                  ->or_where('excerpt', 'LIKE', "%$q%")
                  ->or_where('body', 'LIKE', "%$q%")
                  ->paginate(4)
    );
    return View::make('post/searchresults', $data);
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
