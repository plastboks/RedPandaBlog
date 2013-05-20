<?php

class Admin_Post_Controller extends Base_Controller {
  
  public function __construct() {
    $this->filter('before', 'auth');
  }

  public function action_list() {
    $data = array(
      'pubPosts' => Post::order_by('created_at', 'desc')
                            ->where('published', '=', '1')
                            ->get(),
      'unpubPosts' => Post::order_by('created_at', 'desc')
                            ->where_null('published')
                            ->get(),
    );
    return View::make('admin/post/list', $data);
  }

  public function action_new() {
    $data = array(
      'user' => Auth::user(),
    );
    return View::make('admin/post/new', $data);
  }

  public function action_create() {

    $v = Validator::make(Input::all(), Post::defaultRules());

    if ($v->fails()) {
      return Redirect::to('admin/post/new')
              ->with('user', Auth::user())
              ->with_errors($v)
              ->with_input();
    }

    $post = new Post();
    $post->title = Input::get('title');
    $post->body = Input::get('body');
    $post->author_id = Input::get('author_id');
    $post->published = Input::get('published');
    $post->save();

    return Redirect::to('post/view/'.$post->id);
  }

  public function action_edit($id) {
    $data = array(
      'post' => Post::find($id),
      'user' => Auth::user(),
    );
    return View::make('admin/post/edit', $data);
  }

  public function action_update($id) {

    $v = Validator::make(Input::all(), Post::defaultRules());

    if ($v->fails()) {
      return Redirect::to('admin/post/edit/'.$id)
              ->with('user', Auth::user())
              ->with_errors($v)
              ->with_input();
    }

    if ($post = Post::find($id)) {
      $post->title = Input::get('title');
      $post->body = Input::get('body');
      $post->author_id = Input::get('author_id');
      $post->published = Input::get('published');
      $post->save();
      return Redirect::to('post/view/'.$id);
    }
  }

  public function action_publish($id) {
    if ($post = Post::find($id)) {
      $post->published = 1;   
      $post->save();
    }
    return Redirect::to('admin/post/list');
  }

  public function action_unpublish($id) {
    if ($post = Post::find($id)) {
      $post->published = NULL;
      $post->save();
    }
    return Redirect::to('admin/post/list');
  }

  public function action_delete($id) {
    if ($post = Post::find($id)) {
      $post->delete();
      return Redirect::to('admin/post/list');
    } else {
      return Redirect::to('admin/post/list');
    }
  }
}
