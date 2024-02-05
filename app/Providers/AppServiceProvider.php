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
        $this->app->bind(
            'App\Services\Interfaces\ProductTypeServiceInterface',
            'App\Services\ProductTypeService'
        );
        $this->app->bind(
            'App\Services\Interfaces\ProductServiceInterface',
            'App\Services\ProductService'
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
