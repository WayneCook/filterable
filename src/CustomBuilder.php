<?php

namespace WayneCook\Filterable;

use Illuminate\Validation\ValidationException;
use WayneCook\Filterable\CustomQueryBuilder;
use WayneCook\Filterable\FilterValidator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use WayneCook\Filterable\Filter;
use Illuminate\Http\Request;


class CustomBuilder extends Builder {

    protected $filters;
    protected $allowedFilters;
    protected $customQueryBuilder;

    public function __construct($builder, CustomQueryBuilder $customQueryBuilder, FilterValidator $filters)
    {

        parent::__construct(clone $builder->getQuery());

        $this->initializeFromBuilder($builder::query());

        $this->filters = $filters->get();

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

        if(is_array($columns)) {
            $this->allowedFilters = $columns;
        }

        if($this->filters->fails()) {
            return $this->filters->errors();
        }

        return $this->customQueryBuilder->apply($this);
    }

    public function filters()
    {
        return $this->filters;
    }

    public function getAllowedFilters()
    {
        return $this->allowedFilters;
    }

}
