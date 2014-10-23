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

Route::group(['before' => 'oauth'], function()
{
	Route::get('logout', ['uses' => 'AuthenticationController@logout']);
	Route::get('/', ['uses' => 'HomeController@showWelcome']);
});



