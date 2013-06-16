<?php 

class AccountController extends BaseController 
{
    
    /**
     * Sets persmission and loads the parents contruct
     *
     * @return void
     */
    public function __construct() 
    {
        parent::__construct();
        Route::filter('before', 'auth');
    }

    /**
     * Index view 
     *
     * @return view
     */
    public function getIndex() 
    {
        Route::filter('before', 'auth');
        return View::make('account/welcome');
    }

    /**
     * Profile view 
     *
     * @return view
     */
    public function getProfile() 
    {
        $data = array(
            'user' => Auth::user(),
            'status' => Session::get('status'),
        );
        return View::make('account/profile', $data);
    }

    /**
     * Password view 
     *
     * @return view
     */
    public function getPassword() 
    {
            $data = array(
                'error' => Session::get('error'),
                'status' => Session::get('status'),
            );
            return View::make('account/password', $data);
    }

    /**
     * Myposts view
     *
     * @return view
     */
    public function getMyposts() 
    {
        $user = User::find(Auth::user()->id);
        $data = array(
            'posts' => $user->posts()->paginate(10),
        );
        return View::make('account/myposts', $data);
    }
    
    /**
     * Update user action
     *
     * @return redirect
     */
    public function postUpdate() 
    {
        $user = Auth::user();

        $v = Validator::make(Input::all(), User::defaultRules($user->id));

        if ($v->fails()) {
            return Redirect::to('account/profile')
                      ->with('user', Auth::user())
                      ->withErrors($v)
                      ->withInput();
        }

        if ($dbUser = User::find($user->id)) {
            $dbUser->username = Input::get('username');
            $dbUser->email = Input::get('email');
            $dbUser->givenname = Input::get('givenname');
            $dbUser->surname = Input::get('surname');
            $dbUser->info = Input::get('info');
            $dbUser->save();
            return Redirect::to('account/profile')
                       ->with('user', Auth::user())
                       ->with('status', 'User updated!');
        }
    }

    /**
     * Changepassword action
     *
     * @return redirect
     */
    public function postChangepassword() 
    {
        $user = User::find(Auth::user()->id);

        $v = Validator::make(Input::all(), User::passwordRules());

        if ($v->fails()) {
            return Redirect::to('account/password')
                      ->withErrors($v)
                      ->withInput();
        }

        if ($user) {
            if (Hash::check(Input::get('old_password'), $user->password)) {
                $user->password = Hash::make(Input::get('password'));
                $user->save();
                return Redirect::to('account/password')
                          ->with('status', 'Password changed');
            } else {
                return Redirect::to('account/password')
                          ->with('error', 'Incorrect password');
            }
        }

        return Redirect::error(404);
    }

}

