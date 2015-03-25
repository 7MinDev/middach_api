<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::post('login', [
	'as' => 'login',
	'uses' => 'Auth\AuthenticationController@login'
]);

Route::post('register', [
	'as' => 'register',
	'uses' => 'Auth\AuthenticationController@register'
]);

Route::post('activate', [
	'as' => 'activate',
	'uses' => 'Auth\AuthenticationController@activate'
]);

Route::post('reset', [
	'as' => 'reset',
	'uses' => 'Auth\AuthenticationController@reset'
]);

Route::post('processReset', [
	'as' => 'processReset',
	'uses' => 'Auth\AuthenticationController@processReset'
]);

Route::get('restaurants/{id}', [
	'as' => 'restaurants.find',
	'uses' => 'RestaurantsController@show'
]);

/*
 * Private routes that need authentication
 *
 * Insert Resource routes here!
 */
Route::group(['before' => 'oauth'], function()
{
	Route::get('logout', [
		'as' => 'logout',
		'uses' => 'Auth\AuthenticationController@logout'
	]);

	Route::post('restaurants/create', [
		'as' => 'restaurants.create',
		'uses' => 'Admin\RestaurantsController@create'
	]);

	Route::put('restaurants/update/{id}', [
		'as' => 'restaurants.update',
		'uses' => 'Admin\RestaurantsController@update'
	]);

	Route::delete('restaurants/delete/{id}', [
		'as' => 'restaurants.delete',
		'uses' => 'Admin\RestaurantsController@delete'
	]);

	Route::post('restaurants/opening_time/create', [
		'as' => 'restaurants.opening_time.create',
		'uses' => 'Admin\OpeningTimesController@create'
	]);

	Route::put('restaurants/opening_time/update/{id}', [
		'as' => 'restaurants.opening_time.update',
		'uses' => 'Admin\OpeningTimesController@update'
	]);

	Route::delete('restaurants/opening_time/delete/{id}', [
		'as' => 'restaurants.opening_time.delete',
		'uses' => 'Admin\OpeningTimesController@delete'
	]);
});

