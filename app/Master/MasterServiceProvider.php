<?php namespace App\Master;

use Illuminate\Support\ServiceProvider;

class MasterServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //list
        $this->app->bind('App\Master\Handlers\FrAsignacionListInterface', 'App\Master\Handlers\Repositories\FrAsignacionList');
        $this->app->bind('App\Master\Handlers\EmpresaListInterface', 'App\Master\Handlers\Repositories\EmpresaList');
        $this->app->bind('App\Master\Handlers\FinanceEntityListInterface', 'App\Master\Handlers\Repositories\FinanceEntityList');

        //entity
        $this->app->bind('App\Master\Handlers\SourceLogInterface', 'App\Master\Handlers\Repositories\SourceLogRepository');
        $this->app->bind('App\Master\Handlers\UserInterface', 'App\Master\Handlers\Repositories\UserRepository');
        
    }
}