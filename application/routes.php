<?php

View::share('s', IoC::resolve('settings'));
View::share('p', IoC::resolve('permissions'));

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
Route::post('admin/user/create', array(
                                  'before' => 'csrf',
                                  'uses' => 'admin.user@create'));
Route::post('admin/user/update', array(
                                  'before' => 'csrf',
                                  'uses' => 'admin.user@update'));

Route::controller('admin.post');
Route::get('admin/post/new', 'admin.post@new');
Route::post('admin/post/create', array(
                                  'before' => 'csrf',
                                  'uses' => 'admin.post@create'));
Route::post('admin/post/update', array(
                                  'before' => 'csrf',
                                  'uses' => 'admin.post@update'));

Route::controller('admin.category');
Route::get('admin/category/new', 'admin.category@new');
Route::post('admin/category/create', array(
                                      'before' => 'csrf',
                                      'uses' => 'admin.category@create'));
Route::post('admin/category/update', array(
                                      'before' => 'csrf',
                                      'uses' => 'admin.category@update'));

Route::controller('admin.setting');
Route::get('admin/settings', 'admin.setting@edit');
Route::post('admin/settings', array(
                               'before' => array('csrf', 'admin'),
                               'uses' => 'admin.setting@register'));

Route::controller('admin.role');
Route::post('admin/role/create', array(
                                  'before' => array('csrf'),
                                  'uses' => 'admin.role@create'
                                  ));
Route::post('admin/role/update', array(
                                  'before' => array('csrf'),
                                  'uses' => 'admin.role@update',
                                  ));

Route::get('admin', array('before' => 'auth', function(){
  return View::make('admin/index');
}));


/**
 * account logic
 */
Route::controller("account");
Route::get('account/profile', 'account@profile');
Route::post('account/update', array(
                               'before' => 'csrf',
                               'uses' => 'account@update'));


/**
 * login/logout logic
 */
Route::controller('auth');
Route::get('login', 'auth@login');
Route::post('login', array(
                      'before' => 'csrf', 
                      'uses' => 'auth@try'));
Route::get('logout', 'auth@logout');


/**
 * install area
 */
Route::controller('install');
Route::get('install', 'install@index');
Route::post('install/createuser', array(
                                    'before' => 'csrf',
                                    'uses' => 'install@createuser'));


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

Route::filter('admin', function()
{
  $permissions = IoC::resolve('permissions');
  if ($permissions->myRole != 'admin') {
    return Redirect::error(403);
  }
});
