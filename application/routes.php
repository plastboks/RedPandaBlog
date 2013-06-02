<?php

Route::get('/', array('as' => 'frontpage', 'do' => function() {
  $data = array(
    'posts' => Post::order_by('created_at', 'desc')
                ->where('published', '=', 1)
                ->paginate(4),
  );
  return View::make('frontpage', $data);
}));


/**
 * Post area
 */
Route::controller('post');


/**
 * admin area
 */ 
Route::controller('admin.user');
Route::get('admin/user/new', 'admin.user@new');
Route::post('admin/user/create', 'admin.user@create');
Route::post('admin/user/update', 'admin.user@update');

Route::controller('admin.post');
Route::get('admin/post/new', 'admin.post@new');
Route::post('admin/post/create', 'admin.post@create');
Route::post('admin/post/update', 'admin.post@update');

Route::controller('admin.category');
Route::get('admin/category/new', 'admin.category@new');
Route::post('admin/category/create', 'admin.category@create');
Route::post('admin/category/update', 'admin.category@update');

Route::get('admin', array('before' => 'auth', function(){
  return View::make('admin/index');
}));


/**
 * account logic
 */
Route::controller("account");
Route::get('account/profile', 'account@profile');
Route::post('account/update', 'account@update');


/**
 * login/logout logic
 */
Route::get('login', function(){
  return View::make('login');
});

Route::post('login', array('before' => 'csrf', function(){
  $userdata = array(
    'username' => Input::get('email'),
    'password' => Input::get('password'),
  );

  if (Auth::attempt($userdata)) {
    $user = Auth::user();
    if ($user->blocked) {
      Auth::logout();
      return Redirect::to('login')->with('login_errors', true);
    } else {
      return Redirect::to('account');
    }
  } else {
    return Redirect::to('login')->with('login_errors', true);
  }
}));

Route::get('logout', function(){
  Auth::logout();
  return Redirect::to('login');
});


/**
 * install area
 */
Route::controller('install');
Route::get('install', 'install@index');
Route::post('install/createuser', 'install@createuser');


/**
 * some default error pages
 */
Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function($exception)
{
	return Response::error('500');
});


/**
 * Some default filters
 */
Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});

