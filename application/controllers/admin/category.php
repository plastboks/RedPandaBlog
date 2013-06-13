<?php

class Admin_Category_Controller extends Base_Controller
{
    public function __construct() 
    {
        parent::__construct();
        $this->filter('before', 'auth');
    }

    public function action_list()
    {
        $data = array(
            'categories' => Category::order_by('id', 'asc')
                              ->paginate(10),
        );
        return View::make('admin/category/list', $data);
    }

    public function action_new()
    {
        if (!$this->p->canI('createCategory')) return Redirect::error(403);
        return View::make('admin/category/new');
    }

    public function action_create() 
    {
        if (!$this->p->canI('createCategory')) return Redirect::error(403);
        $v = Validator::make(Input::all(), Category::defaultRules());

        if ($v->fails()) {
          return Redirect::to('admin/category/new')
                  ->with_errors($v)
                  ->with_input();
        }

        $category = new Category();
        $category->title = Input::get('title');
        $category->slug = Input::get('slug');
        $category->save();

        return Redirect::to('admin/category/list');
    }

    public function action_edit($id) 
    {
        if (!$this->p->canI('updateCategory')) return Redirect::error(403);
        $data = array(
            'category' => Category::find($id),
        );
        return View::make('admin/category/edit', $data);
    }

    public function action_update($id) 
    {
        if (!$this->p->canI('updateCategory')) return Redirect::error(403);
        $v = Validator::make(Input::all(), Category::defaultRules());

        if ($v->fails()) {
          return Redirect::to('admin/category/edit/'.$id)
                  ->with_errors($v)
                  ->with_input();
        }

        if ($category = Category::find($id)) {
          $category->title = Input::get('title');
          $category->slug = Input::get('slug');
          $category->save();
          return Redirect::to('admin/category/list');
        }
    }

    public function action_delete($id) 
    {
        if (!$this->p->canI('deleteCategory')) return Redirect::error(403);

        if (($cat = Category::find($id)) && (!Category::find($id)->posts()->get())) {
            $cat->delete();
            return Redirect::to('admin/category/list');
        } else {
            return Redirect::to('admin/category/list');
        }
    }

}
