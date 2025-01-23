<?php namespace App\Core;

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Core\Handlers\ReniecFamiliarInterface', 'App\Core\Handlers\Repositories\ReniecFamiliarRepository');
        $this->app->bind('App\Core\Handlers\ReniecHermanoInterface', 'App\Core\Handlers\Repositories\ReniecHermanoRepository');
        $this->app->bind('App\Core\Handlers\ReniecConyugeInterface', 'App\Core\Handlers\Repositories\ReniecConyugeRepository');
        $this->app->bind('App\Core\Handlers\ReniecInterface', 'App\Core\Handlers\Repositories\ReniecRepository');

        $this->app->bind('App\Core\Handlers\ClaroInterface', 'App\Core\Handlers\Repositories\ClaroRepository');
        $this->app->bind('App\Core\Handlers\EntelInterface', 'App\Core\Handlers\Repositories\EntelRepository');
        $this->app->bind('App\Core\Handlers\BitelInterface', 'App\Core\Handlers\Repositories\BitelRepository');
        $this->app->bind('App\Core\Handlers\MovistarInterface', 'App\Core\Handlers\Repositories\MovistarRepository');
        $this->app->bind('App\Core\Handlers\MovistarFijoInterface', 'App\Core\Handlers\Repositories\MovistarFijoRepository');

        $this->app->bind('App\Core\Handlers\EssaludInterface', 'App\Core\Handlers\Repositories\EssaludRepository');
        $this->app->bind('App\Core\Handlers\CorreoInterface', 'App\Core\Handlers\Repositories\CorreoRepository');

        $this->app->bind('App\Core\Handlers\VehiculosDocumentoInterface', 'App\Core\Handlers\Repositories\VehiculosDocumentoRepository');
        $this->app->bind('App\Core\Handlers\EmpresasDocumentoInterface', 'App\Core\Handlers\Repositories\EmpresasDocumentoRepository');
        $this->app->bind('App\Core\Handlers\EmpresasRepresentanteInterface', 'App\Core\Handlers\Repositories\EmpresaRepresentantesRepository');
        $this->app->bind('App\Core\Handlers\EmpresaInterface', 'App\Core\Handlers\Repositories\EmpresaRepository');
        $this->app->bind('App\Core\Handlers\EmpresaTelefonoInterface', 'App\Core\Handlers\Repositories\EmpresaTelefonoRepository');
        
        $this->app->bind('App\Core\Handlers\SbsInterface', 'App\Core\Handlers\Repositories\SbsRepository');
        $this->app->bind('App\Core\Handlers\SbsDetalleInterface', 'App\Core\Handlers\Repositories\SbsDetalleRepository');
    }
}