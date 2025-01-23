<?php

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'scoring'], function () {
        Route::get('new-period', [
            'as' => 'scoring_new_period',
            'uses' => '\App\Scoring\Controllers\ScoringController@index'
        ]);
        Route::get('historic', [
            'as' => 'scoring_historic',
            'uses' => '\App\Scoring\Controllers\ScoringController@historic'
        ]);
        Route::get('match', [
            'as' => 'scoring_match',
            'uses' => '\App\Scoring\Controllers\ScoringController@match'
        ]);
        Route::get('settings', [
            'as' => 'scoring_settings',
            'uses' => '\App\Scoring\Controllers\ScoringController@settings'
        ]);
    });
});
