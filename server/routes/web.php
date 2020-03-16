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
        		Route::post('logout', 'Auth\LoginController@logout')->name('logout');
			}
		);
	}
);