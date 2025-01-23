<?php

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'master'], function () {

        Route::group(["prefix" => "user"], function () {
            Route::get('', [
                'as' => 'master.user.index',
                'uses' => '\App\Master\Controllers\UserController@index'
            ]);
            Route::get('{userId}/show', [
                'as' => 'master.user.show',
                'uses' => '\App\Master\Controllers\UserController@show'
            ]);
            Route::get('{userId}/destroy', [
                'as' => 'master.user.destroy',
                'uses' => '\App\Master\Controllers\UserController@destroy'
            ]);
            Route::post('store', [
                'as' => 'master.user.store',
                'uses' => '\App\Master\Controllers\UserController@store'
            ]);

            Route::get('access', [
                'as' => 'master.user.access.index',
                'uses' => '\App\Master\Controllers\UserController@accesIndex'
            ]);
            Route::get('validate-min-old-password', [
                'as' => 'master.user.validate_min_old_password.index',
                'uses' => '\App\Master\Controllers\UserController@validateMinOldPassword'
            ]);
        });

        Route::group(["prefix" => "module"], function () {
            Route::get('', [
                'as' => 'master.module.index',
                'uses' => '\App\Master\Controllers\ModuleController@index'
            ]);
            Route::get('{moduleId}/show', [
                'as' => 'master.module.show',
                'uses' => '\App\Master\Controllers\ModuleController@show'
            ]);
            Route::get('{moduleId}/destroy', [
                'as' => 'master.module.destroy',
                'uses' => '\App\Master\Controllers\ModuleController@destroy'
            ]);
            Route::post('store', [
                'as' => 'master.module.store',
                'uses' => '\App\Master\Controllers\ModuleController@store'
            ]);
        });

        Route::group(["prefix" => "roles"], function () {
            Route::get('', [
                'as' => 'master.roles.index',
                'uses' => '\App\Master\Controllers\RoleController@index'
            ]);
            Route::get('{roleId}/show', [
                'as' => 'master.role.show',
                'uses' => '\App\Master\Controllers\RoleController@show'
            ]);
            Route::get('{roleId}/destroy', [
                'as' => 'master.role.destroy',
                'uses' => '\App\Master\Controllers\RoleController@destroy'
            ]);
            Route::post('store', [
                'as' => 'master.role.store',
                'uses' => '\App\Master\Controllers\RoleController@store'
            ]);
        });
    });
});
