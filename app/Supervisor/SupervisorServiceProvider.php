<?php namespace App\Supervisor;

use Illuminate\Support\ServiceProvider;

class SupervisorServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //list
        $this->app->bind('App\Supervisor\Handlers\UploadCorreoListInterface', 'App\Supervisor\Handlers\Repositories\UploadCorreoList');

        //entity
        
    }
}