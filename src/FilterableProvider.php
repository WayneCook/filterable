<?php

namespace WayneCook\Filterable;

use WayneCook\Filterable\CustomQueryBuilder;
use WayneCook\Filterable\FilterValidator;
use Illuminate\Support\ServiceProvider;
use WayneCook\Filterable\CustomBuilder;
use Illuminate\Http\Request;


class FilterableProvider extends ServiceProvider
{

    public function register()
    {

        $this->mergeConfigFrom(__DIR__.'/../config/allowed-operators.php', 'operators');

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
