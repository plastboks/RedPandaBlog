<?php

class InstallController extends BaseController 
{

    /**
     * Index view
     *
     * @return view
     */
    public function getIndex() 
    {
        if (User::all()) {
            return Redirect::to('/')
                      ->with('status', 'Users exists');
        }
        $data = array(
            'status' => Session::get('status'),
            'username' => Session::get('username'),
            'email' => Session::get('email'),
        );
        return View::make('install', $data);
    }

    /**
     * Create user action
     *
     * @return redirect
     */
    public function postCreateuser() 
    {
        if (User::all()) {
            return Redirect::to('/')
                            ->with('status', 'Users exists');
        }
        $v = Validator::make(Input::all(), User::defaultRules());
        if ($v->fails()) {
            return Redirect::to('install')
                      ->withErrors($v)
                      ->withInput();
                      ->with('username', Input::get('username'))
                      ->with('email', Input::get('email'))
        }

        $user = new User();
        $user->username = Input::get('username');
        $user->email = Input::get('email');
        $user->role_id = 1;
        $user->password = Hash::make(Input::get('password'));
        $user->save();
        return Redirect::to('login')
                  ->with('status', 'New user created');
    }

}

