<?php

class AdminUserController extends BaseController
{

    /**
     * Sets persmission and load parents contruct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        Route::filter('before', array('auth'));
    }

    /**
     * Users list view (unblocked)
     *
     * @return view
     */
    public function getList()
    {
        if (!$this->p->canI('seeUsers')) return App::abort(403, 'Forbidden');

        $data = array(
            'myself' => Auth::user(),
            'users' => User::orderBy('id', 'asc')
                                ->whereNull('blocked')
                                ->paginate(10),
            'status' => Session::get('status'),
            'title' => 'Active users',
            'action' => 'block',
        );
        return View::make('admin/user/list', $data);
    }

    /**
     * Users list view (blocked)
     *
     * @return view
     */
    public function getBlocked()
    {
        if (!$this->p->canI('seeUsers')) return App::abort(403, 'Forbidden');

        $data = array(
            'myself' => Auth::user(),
            'users' => User::orderBy('id', 'asc')
                                ->where('blocked', '=', '1')
                                ->paginate(10),
            'status' => Session::get('status'),
            'title' => 'Blocked users',
            'action' => 'unblock',
        );
        return View::make('admin/user/list', $data);
    }

    /**
     * User edit view
     *
     * @params userid
     *
     * @return view
     */
    public function getEdit($id)
    {
        if (!$this->p->canI('updateUser')) return App::abort(403, 'Forbidden');
        if ($id == 1) return App::abort(403, 'Forbidden');

        $myself = Auth::user();
        $formRoles = array();
        foreach (Role::all() as $role) {
            $formRoles[$role->id] = ucwords($role->name);
        }

        if ($myself->id == $id) {
            return Redirect::to('account/profile');
        } elseif ($user = User::find($id)) {
            $data = array(
                'user' => $user,
                'status' => Session::get('status'),
                'roles' => $formRoles,
            );
            return View::make('admin/user/edit', $data);
        }
        return Redirect::to('admin/users');
    }

    /**
     * New user view
     *
     * @return view
     */
    public function getNew()
    {
        if (!$this->p->canI('createUser')) return App::abort(403, 'Forbidden');

        $formRoles = array();
        foreach (Role::all() as $role) {
            $formRoles[$role->id] = ucwords($role->name);
        }
        $data = array(
            'status' => Session::get('status'),
            'username' => Session::get('username'),
            'email' => Session::get('email'),
            'roles' => $formRoles,
        );
        return View::make('admin/user/new', $data);
    }

    /**
     * Create user action
     *
     * @return redirect
     */
    public function postCreate()
    {
        if (!$this->p->canI('createUser')) return App::abort(403, 'Forbidden');

        $v = Validator::make(Input::all(), User::defaultRules());

        if ($v->fails()) {
            return Redirect::to('admin/user/new')
                      ->withErrors($v)
                      ->with('username', Input::get('username'))
                      ->with('email', Input::get('email'))
                      ->withInput();
        }

        $user = new User();
        $user->username = Input::get('username');
        $user->email = Input::get('email');
        $user->givenname = Input::get('givenname');
        $user->surname = Input::get('surname');
        $user->info = Input::get('info');
        $user->role_id = Input::get('role');
        $user->password = Hash::make(Input::get('password'));
        $user->save();
        return Redirect::to('admin/user/list')
                  ->with('status', 'New user created');
    }

    /**
     * Users update action
     *
     * @params userid
     *
     * @return redirect
     */
    public function postUpdate($id)
    {
        if (!$this->p->canI('updateUser')) return App::abort(403, 'Forbidden');
        if ($id == 1) return App::abort(403, 'Forbidden');

        $v = Validator::make(Input::all(), User::defaultRules($id));

        if ($v->fails()) {
            return Redirect::to('admin/user/edit/'.$id)
                      ->withErrors($v);
        }

        if ($user = User::find($id)) {
            $user->username = Input::get('username');
            $user->email = Input::get('email');
            $user->givenname = Input::get('givenname');
            $user->surname = Input::get('surname');
            $user->info = Input::get('info');
            $user->role_id = Input::get('role');
            if (Input::get('password')) {
                $user->password = Hash::make(Input::get('password'));
            }
            $user->save();
            return Redirect::to('admin/user/list')
                      ->with('status', "User updated");
        }
    }

    /**
     * Block user action
     *
     * @params userid
     *
     * @return redirect
     */
    public function getBlock($id)
    {
        if (!$this->p->canI('blockUser')) return App::abort(403, 'Forbidden');
        if ($id == 1) return App::abort(403, 'Forbidden');

        if ($user = User::find($id)) {
            $user->blocked = 1;
            $user->save();
        }
        return Redirect::to('admin/user/list');
    }

    /**
     * Unblock user action
     *
     * @params userid
     *
     * @return redirect
     */
    public function getUnblock($id)
    {
        if (!$this->p->canI('unblockUser')) return App::abort(403, 'Forbidden');

        if ($user = User::find($id)) {
            $user->blocked = NULL;
            $user->save();
        }
        return Redirect::to('admin/user/blocked');
    }

    /**
     * Delete user action
     *
     * @return redirect
     */
    public function getDelete($id)
    {
        if (!$this->p->canI('deleteUser')) return App::abort(403, 'Forbidden');
        if ($id == 1) return App::abort(403, 'Forbidden');

        if (($id != Auth::user()->id) && ($user = User::find($id))) {
            if (!count($user->posts()->get())) {
                $user->delete();
            }
        }
        return Redirect::to('admin/user/list');
    }

}

