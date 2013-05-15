<?php

Route::get('/', array('as' => 'frontpage', 'do' => function() {
  return View::make('frontpage');
}));


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


/**
 * admin area
 */ 
Route::controller('admin');


/**
 * account logic
 */
Route::controller("account");



/**
 * login/logout logic
 */
Route::get('login', function(){
  return View::make('login');
});

Route::post('login', function(){
  $userdata = array(
    'username' => Input::get('email'),
    'password' => Input::get('password'),
  );

  if (Auth::attempt($userdata)) {
    return Redirect::to('account/welcome');
  } else {
    return Redirect::to('login')->with('login_errors', true);
  }
});

Route::get('logout', function(){
  Auth::logout();
  return Redirect::to('login');
});
