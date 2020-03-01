<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*|==========| Auth |==========|*/

Route::group(
	[
		'middleware' => 'guest',
	],
	function () {
		Route::post('register', 'Api\AuthController@register')->name('register');
		Route::post('login', 'Api\AuthController@login')->name('login');
		Route::post('refresh-token', 'Api\AuthController@refreshToken')->name('refresh_token');
	}
);

Route::group(
	[
		'middleware' => 'auth:api',
	],
	function () {
		Route::post('logout', 'Api\AuthController@logout')->name('logout');
	}
);

/*|==========| Public |==========|*/

/*|=====| Categories |=====|*/

Route::group(
	[
		'as' => 'api.categories.',
		'prefix' => 'categories',
	],
	function () {
		Route::post('', 'Api\CategoryController@index')->name('index');
	}
);
