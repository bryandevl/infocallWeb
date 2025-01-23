<?php namespace App\Operador;

use Illuminate\Support\ServiceProvider;

class OperadorServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //list
        $this->app->bind('App\Operador\Handlers\UploadProcessTranslateListInterface', 'App\Operador\Handlers\Repositories\UploadProcessTranslateList');
        $this->app->bind('App\Operador\Handlers\UploadPhoneWhatsappListInterface', 'App\Operador\Handlers\Repositories\UploadPhoneWhatsappList');

        //entity
        
    }
}