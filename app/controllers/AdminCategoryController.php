<?php

class AdminCategoryController extends BaseController
{
    /**
     * Sets persmission and load parents contruct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        Route::filter('before', 'auth');
    }

    /**
     * List view
     *
     * @return view
     */
    public function getList()
    {
        $data = array(
            'categories' => Category::orderBy('id', 'asc')
                              ->paginate(10),
            'status' => Session::get('status'),
        );
        return View::make('admin/category/list', $data);
    }

    /**
     * New category view
     *
     * @return view
     */
    public function getNew()
    {
        if (!$this->p->canI('createCategory')) return App::abort(403, 'Forbidden');

        return View::make('admin/category/new');
    }

    /**
     * Edit category view
     *
     * @params categoryid
     *
     * @return view
     */
    public function getEdit($id)
    {
        if (!$this->p->canI('updateCategory')) return App::abort(403, 'Forbidden');

        $data = array(
            'category' => Category::find($id),
        );
        return View::make('admin/category/edit', $data);
    }

    /**
     * Create category view
     *
     * @return redirect
     */
    public function postCreate()
    {
        if (!$this->p->canI('createCategory')) return App::abort(403, 'Forbidden');

        $v = Validator::make(Input::all(), Category::defaultRules());

        if ($v->fails()) {
            return Redirect::to('admin/category/new')
                    ->withErrors($v)
                    ->withInput();
        }

        $category = new Category();
        $category->title = Input::get('title');
        $category->slug = Input::get('slug');
        $category->save();

        return Redirect::to('admin/category/list')
                ->with('status', 'New category '.$category->title.' created.');
    }

    /**
     * Update category action
     *
     * @params categoryid
     *
     * @return redirect
     */
    public function postUpdate($id)
    {
        if (!$this->p->canI('updateCategory')) return App::abort(403, 'Forbidden');

        $v = Validator::make(Input::all(), Category::defaultRules());

        if ($v->fails()) {
            return Redirect::to('admin/category/edit/'.$id)
                    ->withErrors($v)
                    ->withInput();
        }

        if ($category = Category::find($id)) {
            $category->title = Input::get('title');
            $category->slug = Input::get('slug');
            $category->save();
            return Redirect::to('admin/category/list')
                    ->with('status', 'Category '.$category->title.' updated');
        }
    }

    /**
     * Category search view
     *
     * @params categoryid
     *
     * @return view
     */
    public function postDelete($id)
    {
        if (!$this->p->canI('deleteCategory')) return App::abort(403, 'Forbidden');

        if (($cat = Category::find($id)) && (!Category::find($id)->posts()->get())) {
            $cat->delete();
            return Redirect::to('admin/category/list');
        } else {
            return Redirect::to('admin/category/list');
        }
    }

}

