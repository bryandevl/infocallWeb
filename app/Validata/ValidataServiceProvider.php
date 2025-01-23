<?php namespace App\Validata;

use Illuminate\Support\ServiceProvider;

class ValidataServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Validata\Handlers\ValidataPeopleInterface', 'App\Validata\Handlers\Repositories\ValidataPeopleRepository');
        $this->app->bind('App\Validata\Handlers\ValidataPeopleSbsInterface', 'App\Validata\Handlers\Repositories\ValidataPeopleSbsRepository');
        $this->app->bind('App\Validata\Handlers\ValidataPeopleEssaludInterface', 'App\Validata\Handlers\Repositories\ValidataPeopleEssaludRepository');
        $this->app->bind('App\Validata\Handlers\ValidataPeopleEmailsInterface', 'App\Validata\Handlers\Repositories\ValidataPeopleEmailsRepository');
        $this->app->bind('App\Validata\Handlers\ValidataPeopleRelativesInterface', 'App\Validata\Handlers\Repositories\ValidataPeopleRelativesRepository');
        $this->app->bind('App\Validata\Handlers\ValidataPeoplePhonesInterface', 'App\Validata\Handlers\Repositories\ValidataPeoplePhonesRepository');
        $this->app->bind('App\Validata\Handlers\ValidataPeopleAddressInterface', 'App\Validata\Handlers\Repositories\ValidataPeopleAddressRepository');
        $this->app->bind('App\Validata\Handlers\ValidataPeopleVehicleInterface', 'App\Validata\Handlers\Repositories\ValidataPeopleVehicleRepository');
        $this->app->bind('App\Validata\Handlers\ValidataCompanyInterface', 'App\Validata\Handlers\Repositories\ValidataCompanyRepository');

        $this->app->bind('App\Validata\Handlers\ValidataSearchInterface', 'App\Validata\Handlers\Repositories\ValidataSearchRepository');

        $this->app->bind('App\Validata\Handlers\ValidataPeopleRepresentativeInterface', 'App\Validata\Handlers\Repositories\ValidataPeopleRepresentativeRepository');
        
    }
}