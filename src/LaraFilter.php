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
            //     ->orderBy(
            //     request('sortBy')[0],
            //     filter_var(request('sortDesc')[0], FILTER_VALIDATE_BOOLEAN) ? 'desc' : 'asc'
            // )
            ->paginate(request('itemsPerPage', 10))]);
    }

    // public function scopeExportExcel($query)
    // {

    //     return response()->json([
    //         'collection' => $this->process($query, request()->all())
    //             ->orderBy(
    //             request('sortBy')[0],
    //             filter_var(request('sortDesc')[0], FILTER_VALIDATE_BOOLEAN) ? 'desc' : 'asc'
    //         )
    //         ->get()]);
    // }

    public function process($query, $data, $config)
    {
        return (new CustomQueryBuilder($query, $data, $config))->apply();
    }


}
