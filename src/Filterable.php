<?php

namespace WayneCook\Filterable;


class Filterable
{

    public static function for($model) {

        return app()->make('CustomBuilder', [
            'model' => $model
            ]);
    }

}
