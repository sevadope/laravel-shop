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
		Route::post('user', 'Api\AuthController@user')->name('user');
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
		Route::post('{category}', 'Api\CategoryController@show')->name('show');
		Route::post('{category}/products', 'Api\CategoryController@products')->name('products');
	}
);

/*|=====| Products |=====|*/

Route::group(
	[
		'as' => 'api.products.',
		'prefix' => 'products',
	],
	function () {
		Route::post('{product}', 'Api\ProductController@show')->name('show');
	}
);

/*|=====| Cart |=====|*/

Route::group(
	[
		'as' => 'api.cart.',
		'prefix' => 'cart',
		'middleware' => 'auth:api',
	],
	function () {
		Route::post('', 'Api\CartController@show')->name('show');
	}
);