<?php
namespace WayneCook\Filterable;


class FilterValidator
{

    protected $filters;


    public function __construct($filters) {

        $this->filters = $filters;
        $this->validateFilters();
    }

    public function validateFilters() {

        $this->filters = validator()->make($this->filters->all(), $this->rules());

    }

    public function get() {

        return $this->filters;

    }

    protected function rules() {
        return [
            'order_by' => 'required_with:order_direction|in:'.$this->orderableColumns(),
            'order_direction' => 'required_with:order_by|in:asc,desc',
            'limit' => 'sometimes|required|integer|min:1',

            // advanced filter
            'match_all' => 'sometimes|required|in:true,false',
            'filter' => 'sometimes|required|array',
            'f.*.column' => 'required',
            'f.*.operator' => 'required_with:f.*.column|in:'.$this->allowedOperators(),
            'f.*.first_value' => 'required',
            'f.*.second_value' => 'required_if:f.*.operator,between,not_between'
        ];
    }


    protected function whiteListColumns()
    {
        return implode(',', $this->allowedFilters);
    }
    protected function orderableColumns()
    {

        $orderable = ['id','name', 'email'];
        return implode(',', $orderable);
    }
    protected function allowedOperators()
    {
        return implode(',', [
            'equal_to',
            'not_equal_to',
            'less_than',
            'greater_than',
            'between',
            'not_between',
            'contains',
            'starts_with',
            'ends_with',
            'in_the_past',
            'in_the_next',
            'in_the_peroid',
            'less_than_count',
            'greater_than_count',
            'equal_to_count',
            'not_equal_to_count'
        ]);
    }

}
