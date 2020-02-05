<?php

namespace WayneCook\Filterable;
use Illuminate\Support\Str;


class CustomQueryBuilder {


    private $match_all = false;

    public function apply($builder)
    {


        $filters = $builder->filterValidator->validateFilters()->valid();

        if(isset($filters['match_all'])) {
            filter_var($filters['match_all'], FILTER_VALIDATE_BOOLEAN) ?
            $this->match_all = true :
            $this->match_all = false;
        }

        // Check if filters exist
        if(isset($filters['f'])) {

            foreach ($filters['f'] as $filter) {
                $this->{ Str::camel($filter['operator']) }($filter, $builder);
            }
        }

        // Check if order_by exist
        if(isset($filters['order_by']) && isset($filters['order_direction'])) {
            $builder->orderBy($filters['order_by'], $filters['order_direction']);
        }

        return $builder;


        return $builder->paginate(isset($filters['limit']) ? $filters['limit'] : 5);

    }


    public function contains($filter, $builder)
    {
        return $builder->{ $this->is_match() }($filter['column'], 'like', '%'.$filter['first_value'].'%');
    }

    public function equalTo($filter, $builder)
    {
        return $builder->orWhere($filter['column'], $filter['first_value']);
    }

    public function notEqualTo($filter)
    {
        return $this->builder->orWhere($filter['column'], '!=', $filter['first_value']);
    }

    public function lessThan($filter)
    {
        return $this->builder->orWhere($filter['column'], '<', $filter['first_value']);
    }

    public function greaterThan($filter)
    {
        return $this->builder->orWhere($filter['column'], '>', $filter['first_value']);
    }

    public function is_match() {

        return !$this->match_all ? 'orWhere' : 'where';
    }


}
