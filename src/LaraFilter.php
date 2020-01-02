<?php

namespace WayneCook\LaraFilter;
use Illuminate\Validation\ValidationException;
use WayneCook\LaraFilter\CustomQueryBuilder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

trait LaraFilter {

    public function scopeLaraFilter($query)
    {


        return response()->json([
            'collection' => $this->process($query, request()->all(), $this->filterable)
                ->orderBy(request('sortBy', 'id'), request('sortDesc', 'desc'))
                ->paginate(request('itemsPerPage', 5))
            ]);
    }


    public function process($query, $data, $config)
    {
        return (new CustomQueryBuilder($query, $data, $config))->apply();
    }


}
