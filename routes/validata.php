<?php

Route::group(['middleware' => 'auth'], function () {
	Route::group(['prefix' => 'validata'], function () {
		Route::post('custom-search', ['as' => 'validata_custom_search', 'uses' => '\App\Validata\Controllers\GeneralValidataController@customSearch']);

		Route::get('log', ['as' => 'validata_log_index', 'uses' => '\App\Validata\Controllers\LogValidataController@index']);
		Route::get('log/show', ['as' => 'validata_log_show', 'uses' => '\App\Validata\Controllers\LogValidataController@show']);
		Route::get('log/show-chart', ['as' => 'validata_log_show_chart', 'uses' => '\App\Validata\Controllers\LogValidataController@showChart']);
		Route::post('xlsLog', ['as' => 'validata_log_xls', 'uses' => '\App\Validata\Controllers\LogValidataController@xlsLog']);

		Route::get('reporte-sbs', ['as' => 'validata_reporte_sbs_index', 'uses' => '\App\Validata\Controllers\ReporteSbsValidataController@index']);
		Route::get('reporte-sbs-get/{document}', ['as' => 'validata_reporte_sbs_get', 'uses' => '\App\Validata\Controllers\ReporteSbsValidataController@getReport']);

		Route::group(['prefix' => 'search'], function() {
			Route::get('', [
				'as' => 'validata.search.index',
				'uses' => '\App\Validata\Controllers\SearchValidataController@index'
			]);
			Route::post('export/xls', [
				'as' => 'validata.search.exportXls',
				'uses' => '\App\Validata\Controllers\SearchValidataController@exportXls'
			]);
		});
	});
});