<?php

/*|==========| Admin panel |==========|*/

Route::group(
	[
		'domain' => 'admin.eshop.dev',
		'as' => 'admin.',
		'namespace' => 'Admin\Auth',
	],
	function () {

		Route::group(
			[
				'middleware' => 'guest'
			],
			function () {
				Route::get('login', 'LoginController@showLoginForm')->name('login');
        		Route::post('login', 'LoginController@login');
			}
		);

		Route::group(
			[
				'middleware' => 'auth',
			],
			function () {
				Route::get('', function () {
					return "admin panel";
				});
			}
		);
	}
);