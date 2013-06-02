<?php

class Admin_Category_Controller extends Base_Controller
{
    public function __construct() 
    {
        $this->filter('before', 'auth');
    }

    public function action_list()
    {
        $data = array(
            'categories' => Category::order_by('id', 'asc')->get(),
        );
        return View::make('admin/category/list', $data);
    }

    public function action_new()
    {
        return View::make('admin/category/new');
    }

    public function action_create() {

        $v = Validator::make(Input::all(), Category::defaultRules());

        if ($v->fails()) {
          return Redirect::to('admin/category/new')
                  ->with_errors($v)
                  ->with_input();
        }

        $post = new Category();
        $post->title = Input::get('title');
        $post->slug = Input::get('slug');
        $post->save();

        return Redirect::to('admin/category/list');
    }

    public function action_delete($id) {
        if (($cat = Category::find($id)) && (!Category::find($id)->posts()->get())) {
            $cat->delete();
            return Redirect::to('admin/category/list');
        } else {
            return Redirect::to('admin/category/list');
        }
    }
  
}
