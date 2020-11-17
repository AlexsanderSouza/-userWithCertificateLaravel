<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Para chamar UserRepository
        $this->app->bind(
            'App\Repository\IUserRepository', 
            'App\Repository\Impl\UserRepository'
        );

        // Para chamar CertificateRepository
        $this->app->bind(
            'App\Repository\ICertificateRepository', 
            'App\Repository\Impl\CertificateRepository'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
