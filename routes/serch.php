<?php

Route::group(['middleware' => 'auth'], function () {
	Route::group(['prefix' => 'serch'], function () {
		Route::get('dni', ['as' => 'serch_dni_index', 'uses' => '\App\Serch\Controllers\DniSerchController@index']);
		Route::get('dni/show', ['as' => 'serch_dni_show', 'uses' => '\App\Serch\Controllers\DniSerchController@show']);
		Route::post('listDni', ['as' => 'serch_dni_list', 'uses' => '\App\Serch\Controllers\DniSerchController@listDni']);

		Route::get('log', ['as' => 'serch_log_index', 'uses' => '\App\Serch\Controllers\LogSerchController@index']);
		Route::get('log/show', ['as' => 'serch_log_show', 'uses' => '\App\Serch\Controllers\LogSerchController@show']);
		Route::post('listLog', ['as' => 'serch_log_list', 'uses' => '\App\Serch\Controllers\LogSerchController@listDni']);
		Route::post('xlsLog', ['as' => 'serch_log_xls', 'uses' => '\App\Serch\Controllers\LogSerchController@xlsLog']);
		Route::get('log/show-chart', ['as' => 'serch_log_show_chart', 'uses' => '\App\Serch\Controllers\LogSerchController@showChart']);
	});
});