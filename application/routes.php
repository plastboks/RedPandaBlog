<?php

/**
 * Post area
 */
Route::controller('post');
Route::get('/', 'post@index');


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
Route::controller('auth');
Route::get('login', 'auth@login');
Route::post('login', 'auth@try');
Route::get('logout', 'auth@logout');


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

