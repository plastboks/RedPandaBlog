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

View::share('s', App::make('settings'));
View::share('p', App::make('permissions'));

/**
 * Post area
 */
Route::get('/',
           array(
               'uses' => 'PostController@getIndex'));


/**
 * admin area
 */
Route::get('admin/user/new',
            array(
                'uses' => 'AdminUserController@getNet'));

Route::post('admin/user/create',
            array(
                'before' => 'csrf',
                'uses' => 'AdminUserController@postCreate'));

Route::post('admin/user/update',
            array(
                'before' => 'csrf',
                'uses' => 'AdminUserController@postUpdate'));

Route::get('admin/post/new',
           array(
               'uses' => 'AdminPostController@getNew'));

Route::post('admin/post/create',
            array(
                'before' => 'csrf',
                'uses' => 'AdminPostController@postCreate'));

Route::post('admin/post/update',
            array(
                'before' => 'csrf',
                'uses' => 'AdminPostController@postUpdate'));

Route::get('admin/category/new',
           array(
               'uses' => 'AdminCategoryController@getNew'));

Route::post('admin/category/create',
            array(
                'before' => 'csrf',
                'uses' => 'AdminCategoryController@postCreate'));

Route::post('admin/category/update',
            array(
                'before' => 'csrf',
                'uses' => 'AdminCategoryController@postUpdate'));

Route::get('admin/settings',
           array(
               'uses' => 'AdminSettingController@getEdit'));

Route::post('admin/settings',
            array(
                'before' => array('csrf'),
                'uses' => 'AdminSettingController@postRegister'));

Route::post('admin/role/create',
            array(
                'before' => array('csrf'),
                'uses' => 'AdminRoleController@postCreate'));

Route::post('admin/role/update',
            array(
                'before' => array('csrf'),
                'uses' => 'AdminRoleController@postUpdate'));

Route::get('admin', array('before' => 'auth', function(){
  return View::make('admin/index');
}));


/**
 * account logic
 */
Route::get('account',
           array(
               'uses' => 'AccountController@getIndex'));

Route::get('account/profile',
           array(
               'uses' => 'AccountController@getProfile'));

Route::get('account/password',
            array(
                'uses' => 'AccountController@getPassword'));

Route::get('account/myposts',
            array(
                'uses' => 'AccountController@getMyposts'));
Route::post('account/update',
            array(
                'before' => 'csrf',
                'uses' => 'AccountController@postUpdate'));

Route::post('account/changepassword',
            array(
                'before' => 'csrf',
                'uses' => 'AccountController@postChangepassword'));

/**
 * login/logout logic
 */
Route::get('login',
           array(
               'uses' => 'AuthController@getLogin'));

Route::post('login',
            array(
                'before' => 'csrf',
                'uses' => 'AuthController@postTry'));

Route::get('logout',
           array(
               'uses' => 'AuthController@getLogout'));

/**
 * install area
 */
Route::get('install',
           array(
               'uses' => 'InstallController@getIndex'));

Route::post('install/createuser',
            array(
                'before' => 'csrf',
                'uses' => 'InstallController@postCreateuser'));

