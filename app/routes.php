<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Defines the various routes used by Sticky Notes
|
*/

// Create paste route
Route::get('/', 'CreateController@getCreate');
Route::post('create', 'CreateController@postCreate');

// Revise paste route
Route::get('rev/{urlkey}', 'CreateController@getRevision')->where('urlkey', 'p[a-zA-Z0-9]+');
Route::post('revise', 'CreateController@postRevision');

// Show paste routes
Route::get('{urlkey}/{hash?}/{action?}', 'ShowController@getPaste')->where('urlkey', 'p[a-zA-Z0-9]+');
Route::get('diff/{oldkey}/{newkey}', 'ShowController@getDiff');
Route::post('{urlkey}/{hash?}', 'ShowController@postPassword')->where('urlkey', 'p[a-zA-Z0-9]+');

// List paste routes
Route::get('all', 'ListController@getAll');
Route::get('trending/{age?}', 'ListController@getTrending');

// API routes
Route::get('api/{mode}/show/{urlkey}/{hash?}/{password?}', 'ApiController@getShow');
Route::get('api/{mode}/list/{page?}', 'ApiController@getList');
Route::post('api/{mode}/create', 'ApiController@postCreate');

// User operation routes
Route::controller('user', 'UserController');

// Protected routes
Route::group(array('before' => 'auth'), function()
{
	// User pastes route
	Route::get('mypastes', 'ListController@getUserPastes');

	// Admin only routes
	Route::group(array('before' => 'admin'), function()
	{
		// Admin routes
		Route::controller('admin', 'AdminController');
	});
});

// CSRF protection for all forms
Route::when('*', 'csrf', array('post'));
