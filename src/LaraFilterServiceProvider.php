<?php

namespace WayneCook\LaraFilter;

use Illuminate\Support\ServiceProvider;

class LaraFilterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadRoutesFrom(__DIR__.'/routes.php');

    }
}
