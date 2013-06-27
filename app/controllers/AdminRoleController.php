<?php
/**
 * File: AdminRoleController
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
 * Class AdminRoleController
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
class AdminRoleController extends BaseController
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
     * Role list
     *
     * @return view
     */
    public function getList()
    {
        if ($this->p->canI('seeRoles')) {
            $data = array(
                'roles' => Role::orderBy('id', 'asc')
                                  ->paginate(10),
                'status' => Session::get('status'),
                'archive' => false
            );
            return View::make('admin/role/list', $data);
        }
        return App::abort(403, 'Forbidden');
    }

    /**
     * Role list
     *
     * @return view
     */
    public function getArchived()
    {
        if ($this->p->canI('seeArchivedRoles')) {
            $data = array(
                'roles' => Role::onlyTrashed()
                                  ->orderBy('id', 'asc')
                                  ->paginate(10),
                'status' => Session::get('status'),
                'archive' => true,
            );
            return View::make('admin/role/list', $data);
        }
        return App::abort(403, 'Forbidden');
    }

    /**
     * New role view
     *
     * @return view
     */
    public function getNew()
    {
        if (!$this->p->canI('createRole')) {
            return App::abort(403, 'Forbidden');
        }

        $data = array(
            'caps' => Capability::all(),
        );
        return View::make('admin/role/new', $data);
    }

    /**
     * Role edit view
     *
     * @param int $id role_id
     *
     * @return view
     */
    public function getEdit($id)
    {
        if (!$this->p->canI('updateRole')) {
            return App::abort(403, 'Forbidden');
        }

        $data = array(
            'role' => Role::find($id),
            'caps' => Capability::all(),
        );
        return View::make('admin/role/edit', $data);
    }

    /**
     * Delete role action
     *
     * @param int $id role_id
     *
     * @return redirect
     */
    public function getDelete($id)
    {
        if (!$this->p->canI('deleteRole') && $id != 1) {
            return App::abort(403, 'Forbidden');
        }

        if (($cat = Role::find($id)) 
            && (!count(Role::find($id)->users()->get()))
        ) {
            $cat->capabilities()->detach();
            $cat->delete();
            return Redirect::to('admin/role/list');
        }
        return Redirect::to('admin/role/list');
    }

    /**
     * Unelete role action
     *
     * @param int $id role_id
     *
     * @return redirect
     */
    public function getUndelete($id)
    {
        if (!$this->p->canI('undeleteRole') && $id != 1) {
            return App::abort(403, 'Forbidden');
        }

        if (!$role = Role::onlyTrashed()->where('id', '=', $id)) {
            return App::abort(403, 'Forbidden');
        }

        $role->restore();

        return Redirect::to('admin/role/archived');
    }

    /**
     * Truedelete role action
     *
     * @param int $id role_id
     *
     * @return redirect
     */
    public function getTrueDelete($id)
    {
        if (!$this->p->canI('trueDeleteRole') && $id != 1) {
            return App::abort(403, 'Forbidden');
        }

        if (!$role = Role::onlyTrashed()->where('id', '=', $id)) {
            return App::abort(403, 'Forbidden');
        }

        $role->forceDelete();

        return Redirect::to('admin/role/archived');
    }
    
    /**
     * Create role action
     *
     * @return redirect
     */
    public function postCreate()
    {
        if (!$this->p->canI('createRole')) {
            return App::abort(403, 'Forbidden');
        }

        $v = Validator::make(Input::all(), Role::defaultRules());

        if ($v->fails()) {
            return Redirect::back()
                    ->withErrors($v)
                    ->withInput();
        }

        $role = new Role();
        $role->name = Input::get('name');
        $role->save();
        if (Input::get('caps')) {
            $role->capabilities()->sync(Input::get('caps'));
        }
        return Redirect::to('admin/role/list')
                 ->with('status', 'New role '.$role->name.' created.');
    }

    /**
     * Update role action
     *
     * @param int $id role_id
     *
     * @return redirect
     */
    public function postUpdate($id)
    {
        if (!$this->p->canI('updateRole')) {
            return App::abort(403, 'Forbidden');
        }

        $v = Validator::make(Input::all(), Role::defaultRules());

        if ($v->fails()) {
            return Redirect::back()
                    ->withErrors($v)
                    ->withInput();
        }

        if ($role = Role::find($id)) {
            $role->name = Input::get('name');
            $role->save();
            if (Input::get('caps')) {
                $role->capabilities()->sync(Input::get('caps'));
            } else {
                $role->capabilities()->detach();
            }
            return Redirect::to('admin/role/list')
                    ->with('status', 'Role '.$role->name.' updated.');
        }
    }

}

