<?php

class Admin_Role_Controller extends Base_Controller
{
    public function __construct() 
    {
        parent::__construct();
        $this->filter('before', 'auth');
    }

    public function action_list()
    {
        $data = array(
            'roles' => Role::order_by('id', 'asc')
                              ->paginate(10),
        );
        return View::make('admin/role/list', $data);
    }

    public function action_new()
    {
        if (!$this->p->canI('createRole')) return Redirect::error(403);
        $data = array(
            'caps' => Capability::all(),
        );
        return View::make('admin/role/new', $data);
    }

    public function action_edit($id) 
    {
        if (!$this->p->canI('editRole')) return Redirect::error(403);
        $data = array(
            'role' => Role::find($id),
            'caps' => Capability::all(),
        );
        return View::make('admin/role/edit', $data);
    }

    public function action_create()
    {
        if (!$this->p->canI('createRole')) return Redirect::error(403);

        $v = Validator::make(Input::all(), Role::defaultRules());

        if ($v->fails()) {
          return Redirect::to('admin/role/new')
                  ->with_errors($v)
                  ->with_input();
        }

        $role = new Role();
        $role->name = Input::get('name');
        $role->save();
        if (Input::get('caps')) {
            $role->capabilities()->sync(Input::get('caps'));
        }

        return Redirect::to('admin/role/list');
    }

    public function action_update($id)
    {
        if (!$this->p->canI('editRole')) return Redirect::error(403);
        $v = Validator::make(Input::all(), Role::defaultRules());

        if ($v->fails()) {
          return Redirect::to('admin/role/edit/'.$id)
                  ->with_errors($v)
                  ->with_input();
        }

        if ($role = Role::find($id)) {
          $role->name = Input::get('name');
          $role->save();
          if (Input::get('caps')) {
              $role->capabilities()->sync(Input::get('caps'));
          }
          return Redirect::to('admin/role/list');
        }
    }

    public function action_delete($id)
    {
        if (!$this->p->canI('deleteRole') &&
            $id != 1) { return Redirect::error(403); }

        if (($cat = Role::find($id)) && (!Role::find($id)->users()->get())) {
            $cat->delete();
            return Redirect::to('admin/role/list');
        } else {
            return Redirect::to('admin/role/list');
        }
    }
}
