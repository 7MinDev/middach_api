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
Route::post('register', 'AuthenticationController@register');

Route::get('activate/{id}/{code}', 'AuthenticationController@activate');

Route::get('reset', 'AuthenticationController@reset');
Route::get('reset/{id}/{code}', 'AuthenticationController@processReset');

Route::group(['before' => 'oauth'], function()
{
	Route::get('logout', ['uses' => 'AuthenticationController@logout']);
	Route::get('/', ['uses' => 'HomeController@showWelcome']);
});



