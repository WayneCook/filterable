<?php

namespace WayneCook\Filterable\config;

use WayneCook\Filterable\CustomQueryBuilder;
use WayneCook\Filterable\FilterValidator;
use Illuminate\Support\ServiceProvider;
use WayneCook\Filterable\CustomBuilder;
use Illuminate\Http\Request;


class Provider extends ServiceProvider
{

    public function register()
    {

        $this->app->bind('CustomBuilder', function ($app, $options) {
            return  new CustomBuilder($options['model'], new CustomQueryBuilder, new FilterValidator(request()));
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
