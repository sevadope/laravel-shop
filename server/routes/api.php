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
