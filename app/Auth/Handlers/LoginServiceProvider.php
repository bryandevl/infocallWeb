<?php namespace App\Auth\Handlers;

use Illuminate\Support\ServiceProvider;

class LoginServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('App\Auth\Handlers\LoginInterface', 'App\Auth\Handlers\Repository\LoginRepository');
    }
}