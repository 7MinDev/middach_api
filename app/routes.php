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

Route::post('login', [
	'as' => 'login',
	'uses' => 'AuthenticationController@login'
]);

Route::post('register', [
	'as' => 'register',
	'uses' => 'AuthenticationController@register'
]);

Route::get('activate/{id}/{code}', [
	'as' => 'activate',
	'uses' => 'AuthenticationController@activate'
]);

Route::post('reset', [
	'as' => 'reset',
	'uses' => 'AuthenticationController@reset'
]);

Route::put('reset/{id}/{code}', [
	'as' => 'reset',
	'uses' => 'AuthenticationController@processReset'
]);

Route::group(['before' => 'oauth'], function()
{
	Route::get('logout', [
		'as' => 'logout',
		'uses' => 'AuthenticationController@logout'
	]);
});



