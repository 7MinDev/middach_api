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

Route::post('login', 'AuthenticationController@login');

// TODO create global route group with oauth filter
Route::get('logout', ['before' => 'oauth', 'uses' => 'AuthenticationController@logout']);
Route::get('/', ['before' => 'oauth', function()
{
	return View::make('hello', ['user' => Sentinel::getUser()]);

}]);
