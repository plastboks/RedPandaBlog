<?php 

class Admin_Controller extends Base_Controller {
  
  public function __construct() {
    $this->filter('before', 'auth');
  }

  public function action_index() {
    $data = array(
      'posts' => Post::all(),
    );
    return View::make('admin/index', $data);
  }

  public function action_newpost() {
    $data = array(
      'user' => Auth::user(),
    );
    return View::make('admin/newpost', $data);
  }

  public function action_createpost() {
    $new_post = array(
      'title'     => Input::get('title'),
      'body'      => Input::get('body'),
      'author_id' => Input::get('author_id'),
    );

    $rules = array(
      'title' => 'required|min:3|max:128',
      'body'  => 'required',
    );

    $v = Validator::make($new_post, $rules);

    if ($v->fails()) {
      return Redirect::to('admin/newpost')
              ->with('user', Auth::user())
              ->with_errors($v)
              ->with_input();
    }

    $post = new Post($new_post);
    $post->save();

    return Redirect::to('post/view/'.$post->id);
  }

  public function action_updatepost($id) {
    $edit_post = array(
      'title' => Input::get('title'),
      'body' => Input::get('body'),
      'author_id' => Input::get('author_id'),
    );

    $rules = array(
      'title' => 'required|min:3|max:128',
      'body'  => 'required',
    );

    $v = Validator::make($edit_post, $rules);

    if ($v->fails()) {
      return Redirect::to('post/edit/'.$id)
              ->with('user', Auth::user())
              ->with_errors($v)
              ->with_input();
    }

    if ($post = Post::find($id)) {
      $post->title = $edit_post['title'];
      $post->body = $edit_post['body'];
      $post->author_id = $edit_post['author_id'];
      $post->save();
      return Redirect::to('post/view/'.$id);
    }
  }
}
