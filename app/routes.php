<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

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
                               'before' => array('csrf'),
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

