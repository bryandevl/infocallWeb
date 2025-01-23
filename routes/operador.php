<?php

Route::group(['middleware' => 'auth'], function () {
	Route::group(['prefix' => 'operador'], function () {
		Route::group(['prefix' => 'convertir_voz_texto'], function() {
			Route::get('/', [
				'as' => 'operador.convertir_voz_texto.index',
				'uses' => '\App\Operador\Controllers\ConvertirVozATextoController@index'
			]);
			Route::get('/{id}/show', [
				'as' => 'operador.convertir_voz_texto.show',
				'uses' => '\App\Operador\Controllers\ConvertirVozATextoController@show'
			]);
			Route::post('/existFile', [
				'as' => 'operador.convertir_voz_texto.exist_file',
				'uses' => '\App\Operador\Controllers\ConvertirVozATextoController@validateFile'
			]);
			Route::get('/downloadFile/{path}', [
				'as' => 'operador.convertir_voz_texto.download_file',
				'uses' => '\App\Operador\Controllers\ConvertirVozATextoController@download'
			]);
			Route::post('/', [
				'as' => 'operador.convertir_voz_texto.store',
				'uses' => '\App\Operador\Controllers\ConvertirVozATextoController@store'
			]);
		});

		Route::group(["prefix"	=>	"upload-phone-whatsapp"], function() {
			Route::get('/', [
				'as' => 'operador.upload_phone_whatsapp.index',
				'uses' => '\App\Operador\Controllers\UploadPhoneWhatsappController@index'
			]);
			Route::post('/', [
				'as' => 'operador.upload_phone_whatsapp.store',
				'uses' => '\App\Operador\Controllers\UploadPhoneWhatsappController@store'
			]);
			Route::get('/downloadFile/{path}', [
				'as' => 'operador.upload_phone_whatsapp.download_file',
				'uses' => '\App\Operador\Controllers\UploadPhoneWhatsappController@download'
			]);
			Route::get("downloadTemplate", [
				"as" => "operador.upload_phone_whatsapp.download_template",
				"uses" => "\App\Operador\Controllers\UploadPhoneWhatsappController@downloadTemplateCsv"
			]);
		});
	});
});