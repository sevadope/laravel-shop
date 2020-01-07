<?php

Auth::routes();

/*|==========| Public |==========|*/

/*|=====| Categories |=====|*/
Route::group(
	[
		'as' => 'categories.',
	],
	function () {
		Route::get('', 'CategoryController@index')->name('index');
		Route::get('categories/{category}', 'CategoryController@show')->name('show');
	}
);


