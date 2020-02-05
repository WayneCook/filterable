<?php

namespace WayneCook\Filterable;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use WayneCook\Filterable\CustomQueryBuilder;
use WayneCook\Filterable\FilterValidator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use WayneCook\Filterable\Filter;
use Illuminate\Http\Request;


class CustomBuilder extends Builder {

    protected $allowedFilters;
    protected $customQueryBuilder;
    public $filterValidator;

    public function __construct($builder, CustomQueryBuilder $customQueryBuilder, FilterValidator $filterValidator)
    {

        parent::__construct(clone $builder->getQuery());

        $this->initializeFromBuilder($builder::query());

        $this->filterValidator = $filterValidator;

        $this->customQueryBuilder = $customQueryBuilder;

    }

    protected function initializeFromBuilder(Builder $builder)
    {
        $this
            ->setModel($builder->getModel())
            ->setEagerLoads($builder->getEagerLoads());
        $builder->macro('getProtected', function (Builder $builder, string $property) {
            return $builder->{$property};
        });
        $this->scopes = $builder->getProtected('scopes');
        $this->localMacros = $builder->getProtected('localMacros');
        $this->onDelete = $builder->getProtected('onDelete');

    }

    public function filter($columns)
    {

        $this->filterValidator->setAllowedFilters($columns);

        return $this;

    }


    public function get($columns = ['*']) {

        $filters = $this->filterValidator->validateFilters();

        if($filters->fails()) {
            throw new HttpResponseException(response()->json($filters->errors(), 422));
        }

        $this->customQueryBuilder->apply($this);

        return parent::get($columns);

    }

}
