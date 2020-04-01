<?php

/*|==========| Admin panel |==========|*/

Route::group(
	[
		'domain' => 'admin.online-shop.ru',
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
				
				/*|=====| Categories |=====|*/

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

				/*|=====| Products |=====|*/

				Route::group(
					[
						'as' => 'products.',
						'prefix' => 'products',
					],
					function () {
						Route::get('', 'ProductController@index')->name('index');
						Route::get('{product}', 'ProductController@show')->name('show');
					}
				);

				/*|=====| Orders |=====|*/

				Route::group(
					[
						'as' => 'orders.',
						'prefix' => 'orders',
					],
					function () {
						Route::get('', 'OrderController@index')
							->name('index');

						Route::get('processing', 'OrderController@processingList')
							->name('list.processing');

						Route::get('pending', 'OrderController@pendingList')
							->name('list.pending');

						Route::get('succeeded', 'OrderController@succeededList')
							->name('list.succeeded');

						Route::get('{order}', 'OrderController@show')
							->name('show');

						Route::post('{order}/complete', 'OrderController@complete')
							->name('complete');

					}
				);
			}
		);
	}
);