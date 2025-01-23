<?php namespace App\Serch;

use Illuminate\Support\ServiceProvider;

class SerchServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Serch\Handlers\SerchPeopleInfoInterface', 'App\Serch\Handlers\Repositories\SerchPeopleInfoRepository');
        $this->app->bind('App\Serch\Handlers\SerchPeopleSbsInterface', 'App\Serch\Handlers\Repositories\SerchPeopleSbsRepository');
        $this->app->bind('App\Serch\Handlers\SerchPeopleEssaludInterface', 'App\Serch\Handlers\Repositories\SerchPeopleEssaludRepository');
        $this->app->bind('App\Serch\Handlers\SerchPeopleTelefonoInterface', 'App\Serch\Handlers\Repositories\SerchPeopleTelefonoRepository');
        $this->app->bind('App\Serch\Handlers\SerchPeopleCorreoInterface', 'App\Serch\Handlers\Repositories\SerchPeopleCorreoRepository');
        $this->app->bind('App\Serch\Handlers\SerchPeopleFamiliarInterface', 'App\Serch\Handlers\Repositories\SerchPeopleFamiliarRepository');

        $this->app->bind('App\Serch\Handlers\SerchLogInterface', 'App\Serch\Handlers\Repositories\SerchLogRepository');
        
    }
}