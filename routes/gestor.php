<?php

Route::group(['prefix' => 'Gestor', 'middleware' => 'auth'], function () {

    Route::get('clientes', function () {
        // Lógica o vista que se debe devolver para esta ruta
        return view('Gestor.clientes.index'); // Cambia a la vista adecuada
    })->name('Gestor.clientes.index');

});

