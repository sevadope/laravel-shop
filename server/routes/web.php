<?php

/*|==========| Admin panel |==========|*/

Route::group(
	[
		'domain' => 'admin.eshop.dev',
		'as' => 'admin.',
		'namespace' => 'Admin',
	],
	function () {
		Route::group(
			[
				'middleware' => 'guest'
			],
			function () {
				Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
        		Route::post('login', 'Auth\LoginController@login');
			}
		);

		Route::group(
			[
				'middleware' => 'auth',
			],
			function () {
        		Route::post('logout', 'Auth\LoginController@logout')->name('logout');
				
				Route::get('', 'CategoryController@index')->name('home');
				Route::group(
					[
						'as' => 'categories.',
						'prefix' => 'categories',
					],
					function () {
						Route::get('', 'CategoryController@index')->name('index');

						Route::get('new', 'CategoryController@create')
							->middleware('can:create,App\Models\Category')->name('create');

						Route::post('new', 'CategoryController@store')
							->middleware('can:create,App\Models\Category')->name('store');

						Route::get('{category}', 'CategoryController@show')->name('show');

						Route::get('{category}/edit', 'CategoryController@edit')
							->middleware('can:update,category')->name('edit');

						Route::put('{category}', 'CategoryController@update')
							->middleware('can:update,category')->name('update');

						Route::delete('{category}', 'CategoryController@delete')
							->middleware('can:delete,category')->name('delete');
					}
				);
			}
		);
	}
);