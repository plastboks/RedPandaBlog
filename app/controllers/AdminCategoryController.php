<?php
/**
 * File: AdminCategoryController
 * 
 * PHP version 5.4
 *
 * @category Development
 * @package  BaseController
 * @author   Alexander Skjolden <alex@plastboks.net>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License
 * 
 * @link     http://github.com/plastboks/red-panda-blog
 * @date     2013-06-17
 * 
 */


/**
 * Class AdminCategoryController
 *
 * @category Development
 * @package  BaseController
 * @author   Alexander Skjolden <alex@plastboks.net>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License
 *
 * @link     http://github.com/plastboks/red-panda-blog
 * @date     2013-06-17
 *
 */
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
        $this->beforeFilter('auth');
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
            'archived' => false,
        );
        return View::make('admin/category/list', $data);
    }

    /**
     * Archived categories list
     *
     * @return view
     */
    public function getArchived()
    {
        $data = array(
            'categories' => Category::onlyTrashed()
                                  ->orderBy('id', 'asc')
                                  ->paginate(10),
            'status' => Session::get('status'),
            'archived' => true,
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
        if (!$this->p->canI('createCategory')) {
            return App::abort(403, 'Forbidden');
        }

        return View::make('admin/category/new');
    }

    /**
     * Edit category view
     *
     * @param int $id category_id
     *
     * @return view
     */
    public function getEdit($id)
    {
        if (!$this->p->canI('updateCategory')) {
            return App::abort(403, 'Forbidden');
        }

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
        if (!$this->p->canI('createCategory')) {
            return App::abort(403, 'Forbidden');
        }

        $v = Validator::make(Input::all(), Category::defaultRules());

        if ($v->fails()) {
            return Redirect::back()
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
     * @param int $id category_id
     *
     * @return redirect
     */
    public function postUpdate($id)
    {
        if (!$this->p->canI('updateCategory')) {
            return App::abort(403, 'Forbidden');
        }

        $v = Validator::make(Input::all(), Category::defaultRules());

        if ($v->fails()) {
            return Redirect::back()
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
     * Delete (archive) category
     *
     * @param int $id category_id
     *
     * @return view
     */
    public function getDelete($id)
    {
        if (!$this->p->canI('deleteCategory')) {
            return App::abort(403, 'Forbidden');
        }

        if (($cat = Category::find($id))
            && (!count(Category::find($id)->posts()->get()))
        ) {
            $cat->delete();
        }
        return Redirect::to('admin/category/list');
    }

    /**
     * Undelete (unarchive) category
     *
     * @param int $id category_id
     *
     * @return view
     */
    public function getUndelete($id)
    {
        if (!$this->p->canI('undeleteCategory')) {
            return App::abort(403, 'Forbidden');
        }

        if (($cat = Category::onlyTrashed()->where('id', '=', $id))) {
            $cat->restore();
        }
        return Redirect::to('admin/category/archived');
    }

    /**
     * Forcedelete category
     *
     * @param int $id category_id
     *
     * @return view
     */
    public function getTrueDelete($id)
    {
        if (!$this->p->canI('forcedeleteCategory')) {
            return App::abort(403, 'Forbidden');
        }

        if (($cat = Category::onlyTrashed()->where('id', '=', $id))) {
            $cat->forceDelete();
        }
        return Redirect::to('admin/category/archived');
    }

}

