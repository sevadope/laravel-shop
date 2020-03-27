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
		Route::post('register', 'AuthController@register')->name('register');
		Route::post('login', 'AuthController@login')->name('login');
		Route::post('refresh-token', 'AuthController@refreshToken')->name('refresh_token');
	}
);

Route::group(
	[
		'middleware' => 'auth:api',
	],
	function () {
		Route::post('logout', 'AuthController@logout')->name('logout');
		Route::post('user', 'AuthController@user')->name('user');
	}
);

/*|==========| Public |==========|*/

/*|=====| Categories |=====|*/

Route::group(
	[
		'as' => 'categories.',
		'prefix' => 'categories',
	],
	function () {
		Route::post('', 'CategoryController@index')->name('index');
		Route::post('{category}', 'CategoryController@show')->name('show');
		Route::post('{category}/products', 'CategoryController@products')->name('products');
	}
);

/*|=====| Products |=====|*/

Route::group(
	[
		'as' => 'products.',
		'prefix' => 'products',
	],
	function () {
		Route::post('{product}', 'ProductController@show')->name('show');
	}
);

/*|=====| Cart |=====|*/

Route::group(
	[
		'as' => 'cart.',
		'prefix' => 'cart',
		'middleware' => 'auth:api',
	],
	function () {
		Route::post('', 'CartController@show')->name('show');
		Route::post('add', 'CartController@add')->name('add');
		Route::post('remove', 'CartController@remove')->name('remove');
	}
);

/*|=====| Payment |=====|*/

Route::group(
	[
		'as' => 'payment.',
		'prefix' => 'payment',
		'middleware' => 'auth:api',
	],
	function () {
		Route::post('init', 'PaymentController@init')->name('init');
	}
);

/*|=====| Orders |=====|*/

Route::group(
	[
		'as' => 'orders.',
		'prefix' => 'orders',
		'middleware' => 'auth:api',
	],
	function () {
		Route::post('', 'OrderController@index')->name('index');
	}
);

