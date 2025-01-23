<?php

<?php

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'supervisores'], function () {

        // Ruta para el reporte Vicidial
        Route::get('vicidial', [
            'as' => 'supervisores.vicidial.cores.index', // Nombre de la ruta
            'uses' => function () {
                return view('supervisores.vicidial.cores.index'); // Carga la vista desde la ruta especificada
            }
        ]);

    });
});