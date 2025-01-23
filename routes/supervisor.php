<?php

Route::group(['middleware' => 'auth'], function () {
	Route::group(['prefix' => 'supervisores'], function () {

		// Rutas para gestiones de transferencias
		Route::group(['prefix' => 'gestiones'], function() {
			Route::get('transferencias', [
				'as' => 'supervisor.gestion.transferencia.index',
				'uses' => '\App\Supervisor\Controllers\GestionTransferenciaController@index'
			]);
			Route::post('transferencias/result', [
				'as' => 'supervisor.gestion.transferencia.result',
				'uses' => '\App\Supervisor\Controllers\GestionTransferenciaController@resultSearch'
			]);
		});

		// Rutas para gestión de correos
		Route::group(["prefix" => "correos"], function() {
			Route::post("upload", [
				"as" => "supervisores.upload_correo.store",
				"uses"	=>	"\App\Http\Controllers\Supervisores\Cruces\CorreoController@upload"
			]);
			Route::get('upload-list', [
				'as' => "supervisores.upload_list.index",
				'uses' => '\App\Http\Controllers\Supervisores\Cruces\CorreoController@uploadList'
			]);
			Route::get('/downloadFile/{path}', [
				'as' => 'supervisores.upload_correo.download_file',
				'uses' => '\App\Http\Controllers\Supervisores\Cruces\CorreoController@download'
			]);
		});

	/*// Rutas para Reportes Vicidial
	Route::group(['prefix' => 'cruces'], function () {
		Route::get('vicidial/cores', function () {
			return view('supervisores.vicidial.cores.index');
		})->name('vicidial.cores.index');
	});
*/
		//Route::get('/list-correos', [AjustesController::class, 'index'])->name('admin.list_correos')->middleware('auth', 'can:settings.list_correos');
		//Route::get('/get-correos', [AjustesController::class, 'get'])->name('admin.get_correos');




	});
});
