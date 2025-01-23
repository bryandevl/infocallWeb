<?php

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'configuration'], function () {

        Route::group(["prefix" => "site"], function () {
            Route::get('', [
                'as' => 'configuration.site.index',
                'uses' => '\App\Master\Controllers\UserController@index'
            ]);
            
        });

        Route::group(["prefix" => "user"], function () {
            Route::get('', [
                'as' => 'configuration.user.index',
                'uses' => '\App\Configuration\Controllers\ConfigurationUserController@index'
            ]);
            Route::get('{userId}/show', [
                'as' => 'configuration.user.show',
                'uses' => '\App\Configuration\Controllers\ConfigurationUserController@show'
            ]);
            Route::post('store', [
                'as' => 'configuration.user.store',
                'uses' => '\App\Configuration\Controllers\ConfigurationUserController@store'
            ]);
        });
    });
});
