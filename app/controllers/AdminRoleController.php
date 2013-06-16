<?php

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
        Route::filter('before', 'auth');
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
          );
          return View::make('admin/role/list', $data);
        }
        return Redirect::error(403);
    }

    /**
     * New role view
     *
     * @return view
     */
    public function getNew()
    {
        if (!$this->p->canI('createRole')) return Redirect::error(403);
        $data = array(
            'caps' => Capability::all(),
        );
        return View::make('admin/role/new', $data);
    }

    /**
     * Role edit view
     *
     * @params roleid
     *
     * @return view
     */
    public function getEdit($id)
    {
        if (!$this->p->canI('updateRole')) return Redirect::error(403);
        $data = array(
            'role' => Role::find($id),
            'caps' => Capability::all(),
        );
        return View::make('admin/role/edit', $data);
    }

    /**
     * Create role action
     *
     * @return redirect
     */
    public function postCreate()
    {
        if (!$this->p->canI('createRole')) return Redirect::error(403);

        $v = Validator::make(Input::all(), Role::defaultRules());

        if ($v->fails()) {
          return Redirect::to('admin/role/new')
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
     * @return redirect
     */
    public function postUpdate($id)
    {
        if (!$this->p->canI('updateRole')) return Redirect::error(403);
        $v = Validator::make(Input::all(), Role::defaultRules());

        if ($v->fails()) {
          return Redirect::to('admin/role/edit/'.$id)
                  ->withErrors($v)
                  ->withInput();
        }

        if ($role = Role::find($id)) {
          $role->name = Input::get('name');
          $role->save();
          if (Input::get('caps')) {
              $role->capabilities()->sync(Input::get('caps'));
          }
          return Redirect::to('admin/role/list')
                  ->with('status', 'Role '.$role->name.' updated.');
        }
    }

    /**
     * Delete role action
     *
     * @return redirect
     */
    public function getDelete($id)
    {
        if (!$this->p->canI('deleteRole') && $id != 1) {
            return Redirect::error(403);
        }

        if (($cat = Role::find($id)) && (!Role::find($id)->users()->get())) {
            $cat->delete();
            return Redirect::to('admin/role/list');
        }
        return Redirect::to('admin/role/list');
    }

}

