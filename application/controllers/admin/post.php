<?php

class Admin_Post_Controller extends Base_Controller {
  
  public function __construct() {
    parent::__construct();
    $this->filter('before', 'auth');
  }

  public function action_list() {
    $data = array(
      'posts' => Post::order_by('created_at', 'desc')
                            ->where('published', '=', '1')
                            ->paginate(10),
      'title' => 'Published posts',
      'action' => 'unpublish',
    );
    return View::make('admin/post/list', $data);
  }

  public function action_unpublished() {
    $data = array(
      'posts' => Post::order_by('created_at', 'desc')
                            ->where_null('published')
                            ->paginate(10),
      'title' => 'Unpublished posts',
      'action' => 'publish',
    );
    return View::make('admin/post/list', $data);
  }

  public function action_new() {
    if (!$this->p->canI('createPost')) return Redirect::error(403);

    $data = array(
      'user' => Auth::user(),
      'categories' => Category::all(),
    );
    return View::make('admin/post/new', $data);
  }

  public function action_create() {
    if (!$this->p->canI('createPost')) return Redirect::error(403);

    $v = Validator::make(Input::all(), Post::defaultRules());

    if ($v->fails()) {
      return Redirect::to('admin/post/new')
              ->with('user', Auth::user())
              ->with_errors($v)
              ->with_input();
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

    return Redirect::to('post/view/'.$post->id);
  }

  public function action_edit($id) {
    $data = array(
      'post' => Post::find($id),
      'user' => Auth::user(),
      'categories' => Category::all(),
    );
    return View::make('admin/post/edit', $data);
  }

  public function action_update($id) {
    if ($this->p->canI('updatePost')) return Redirect::error(403);

    $v = Validator::make(Input::all(), Post::defaultRules());

    if ($v->fails()) {
      return Redirect::to('admin/post/edit/'.$id)
              ->with('user', Auth::user())
              ->with_errors($v)
              ->with_input();
    }

    if ($post = Post::find($id)) {
      $post->title = Input::get('title');
      $post->excerpt = Input::get('excerpt');
      $post->body = Input::get('body');
      $post->author_id = Input::get('author_id');
      if ($this->p->canI('publishPost')) {
        $post->published = Input::get('published');
      }
      if (Input::get('category')) {
          $post->categories()->sync(Input::get('category'));
      }
      $post->save();
      return Redirect::to('post/view/'.$id);
    }
  }

  public function action_publish($id) {
    if (($this->p->canI('publishPost')) && 
        ($post = Post::find($id))) {
      $post->published = 1;   
      $post->save();
    }
    return Redirect::to('admin/post/unpublished');
  }

  public function action_unpublish($id) {
    if (($this->p->canI('unpublishPost')) &&
        ($post = Post::find($id))) {
      $post->published = NULL;
      $post->save();
    }
    return Redirect::to('admin/post/list');
  }

  public function action_delete($id) {
    if (($this->p->canI('deletePost')) &&
        ($post = Post::find($id))) {
      if ($post->categories()) {
        $post->categories()->delete();
      }
      $post->delete();
      return Redirect::to('admin/post/list');
    }

    return Redirect::to('admin/post/list');
  }
}
