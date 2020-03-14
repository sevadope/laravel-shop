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
				Route::get('', function () {
					return "admin panel";
				});
			}
		);
	}
);