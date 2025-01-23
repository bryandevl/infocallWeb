<?php

//Route::auth();
Route::post("/login", "\App\Auth\Controllers\LoginController@authenticate");
Route::get("/recuperar-contrasena", "\App\Auth\Controllers\LoginController@recoverPasswordView");
Route::post("/recuperar-contrasena", "\App\Auth\Controllers\LoginController@sendEmailRecoverPassword");
Route::get("/resetear-contrasena/{token}", "\App\Auth\Controllers\LoginController@resetPasswordView");
Route::post("/resetear-contrasena", "\App\Auth\Controllers\LoginController@resetPassword");

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::group(['prefix' => 'supervisores'], function () {
        Route::group(['prefix' => 'cruces'], function () {

            Route::group(['prefix' => 'dni'], function () {
                Route::get('create', ['as' => 'supervisores_cruces_dni_create', 'uses' => 'Supervisores\\Cruces\\CrucesDNIController@create']);
                Route::post('store', ['as' => 'supervisores_cruces_dni_store', 'uses' => 'Supervisores\\Cruces\\CrucesDNIController@store']);
                Route::post('show', ['as' => 'supervisores_cruces_dni_show', 'uses' => 'Supervisores\\Cruces\\CrucesDNIController@show']);
            });

            Route::group(['prefix' => 'operadora'], function () {
                Route::get('create', ['as' => 'supervisores_cruces_operadora_create', 'uses' => 'Supervisores\\Cruces\\CrucesOperadoraController@create']);
                Route::post('store', ['as' => 'supervisores_cruces_operadora_store', 'uses' => 'Supervisores\\Cruces\\CrucesOperadoraController@store']);
                Route::post('show', ['as' => 'supervisores_cruces_operadora_show', 'uses' => 'Supervisores\\Cruces\\CrucesOperadoraController@show']);
            });

            Route::group(['prefix' => 'reniec'], function () {
                Route::get('create', ['as' => 'supervisores_cruces_reniec_create', 'uses' => 'Supervisores\\Cruces\\CrucesReniecController@create']);
                Route::post('store', ['as' => 'supervisores_cruces_reniec_store', 'uses' => 'Supervisores\\Cruces\\CrucesReniecController@store']);
                Route::post('show', ['as' => 'supervisores_cruces_reniec_show', 'uses' => 'Supervisores\\Cruces\\CrucesReniecController@show']);
            });

            Route::group(['prefix' => 'essalud'], function () {
                Route::get('create', ['as' => 'supervisores_cruces_essalud_create', 'uses' => 'Supervisores\\Cruces\\EssaludController@create']);
                Route::post('store', ['as' => 'supervisores_cruces_essalud_store', 'uses' => 'Supervisores\\Cruces\\EssaludController@store']);
                Route::post('show', ['as' => 'supervisores_cruces_essalud_show', 'uses' => 'Supervisores\\Cruces\\EssaludController@show']);
                Route::get('modal/{dni}', ['as' => 'supervisores_cruces_essalud_show_modal', 'uses' => 'Supervisores\\Cruces\\EssaludController@showModal']);
            });
            
            Route::group(['prefix' => 'correo'], function () {
                Route::get('create', ['as' => 'supervisores_cruces_correo_create', 'uses' => 'Supervisores\\Cruces\\CorreoController@create']);
                Route::post('store', ['as' => 'supervisores_cruces_correo_store', 'uses' => 'Supervisores\\Cruces\\CorreoController@store']);
                Route::post('show', ['as' => 'supervisores_cruces_correo_show', 'uses' => 'Supervisores\\Cruces\\CorreoController@show']);
                Route::get('modal/{dni}', ['as' => 'supervisores_cruces_correo_show_modal', 'uses' => 'Supervisores\\Cruces\\CorreoController@showModal']);
                Route::get("downloadTemplate", ["as" => "supervisores_cruces_correo_download_template", "uses" => "Supervisores\\Cruces\CorreoController@downloadTemplateCsv"]);
            });
       

        });
    });



 
    Route::group(['prefix' => 'supervisores', 'middleware' => 'auth'], function () {
    
        // Rutas relacionadas con Vicidial
        Route::group(['prefix' => 'vicidial/cores'], function () {
    
            // Ruta principal para Vicidial
            Route::get('/', function () {
                return view('supervisores.vicidial.cores.index');
            })->name('supervisores.vicidial.cores.index');
            
            // Ruta para el reporte 'reportsantgest'
            Route::get('coreone/reportsantgest', function () {
                return view('supervisores.vicidial.cores.coreone.reportsantgest');
            })->name('coreone.reportsantgest');
    
            // Ruta para el reporte 'reportspeech'
            Route::get('coreone/reportspeech', function () {
                return view('supervisores.vicidial.cores.coreone.reportspeech');
            })->name('coreone.reportspeech');
    
            // Ruta para el reporte 'reportwhtasapp'
            Route::get('coreone/reportwhtasapp', function () {
                return view('supervisores.vicidial.cores.coreone.reportwhtasapp');
            })->name('coreone.reportwhtasapp');


             // Ruta para el reporte 'reportHistorico'
             Route::get('coreone/reportHistorico', function () {
                return view('supervisores.vicidial.cores.coreone.reportHistorico');
            })->name('coreone.reportHistorico');


              // Ruta para el reporte 'reportcenconsud'
              Route::get('coreone/reportcencosud', function () {
                return view('supervisores.vicidial.cores.coreone.reportcencosud');
            })->name('coreone.reportcencosud');

               // Ruta para el reporte 'reportmaf'
               Route::get('coreone/reportmaf', function () {
                return view('supervisores.vicidial.cores.coreone.reportmaf');
            })->name('coreone.reportmaf');


                // Ruta para el reporte 'promeesascencosud'
                Route::get('coreone/reportpromesacencosud', function () {
                    return view('supervisores.vicidial.cores.coreone.reportpromesacencosud');
                })->name('coreone.reportpromesacencosud');


                 // Ruta para el reporte 'gestiones ibk'
                 Route::get('coreone/reportgestionibk', function () {
                    return view('supervisores.vicidial.cores.coreone.reportgestionibk');
                })->name('coreone.reportgestionibk');      


                // Ruta para el reporte 'gestiones FALABELLA'
                   Route::get('coreone/reportgestionbfb', function () {
                    return view('supervisores.vicidial.cores.coreone.reportgestionbfb');
                })->name('coreone.reportgestionbfb');      



                         // Ruta para el reporte 'gestiones FALABELLA'
                   Route::get('coreone/reportpromesasbfb', function () {
                    return view('supervisores.vicidial.cores.coreone.reportpromesasbfb');
                })->name('coreone.reportpromesasbfb');      


             // Ruta para el reporte 'PROMESAS DE IBK'
                   Route::get('coreone/reportpromesasibk', function () {
                   return view('supervisores.vicidial.cores.coreone.reportpromesasibk');
                     })->name('coreone.reportpromesasibk');      
            



                 // Ruta para el reporte 'gestiones FOH'
                Route::get('coreone/reportgestFoh', function () {
                  return view('supervisores.vicidial.cores.coreone.reportgestFoh');
                   })->name('coreone.reportgestFoh');    
                   
                   

                     // Ruta para el reporte 'actualizar list'
                Route::get('coreone/updateList', function () {
                    return view('supervisores.vicidial.cores.coreone.updateList');
                     })->name('coreone.updateList');    


                        // Ruta para el reporte 'actualizar list'
                Route::get('coreone/agentproduc', function () {
                    return view('supervisores.vicidial.cores.coreone.agentproduc');
                     })->name('coreone.agentproduc');    

                 
                        // Ruta para el reporte 'Carga asignacion'
                Route::get('coreone/Asignacion', function () {
                    return view('supervisores.vicidial.cores.coreone.Asignacion');
                     })->name('coreone.Asignacion');    



                              // Ruta para el reporte 'Carga asignacion'
                Route::get('coreone/Pagos', function () {
                    return view('supervisores.vicidial.cores.coreone.Pagos');
                     })->name('coreone.Pagos');  
        
            });



    
        });
    
  


    Route::group(['prefix' => 'cuenta'], function () {
        Route::get('/', ['as' => 'cuenta_index', 'uses' => 'Cuenta\\CuentaController@index']);
        Route::post('show', ['as' => 'cuenta_show', 'uses' => 'Cuenta\\CuentaController@show']);
    });
    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes


    Route::group(['prefix' => 'buscarclientes'], function () {
        // Ruta para la vista de index (ver clientes)
        Route::get('/', function () {
            return view('Gestor.clientes.index'); // o lo que necesites hacer
        })->name('Gestor.clientes.index');    
    
        // Ruta para la vista de crear cliente
        Route::get('/create', function () {
            return view('Gestor.clientes.create'); // Redirigir a la vista create.blade.php
        })->name('Gestor.clientes.create');


        Route::get('/show', function () {
            return view('Gestor.clientes.show'); // Redirigir a la vista create.blade.php
        })->name('Gestor.clientes.show');



    });


  




});
