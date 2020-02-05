<?php
namespace WayneCook\Filterable;

class FilterValidator
{

    protected $request;
    protected $allowedFilters;

    public function __construct($request) {
        $this->request = $request;
    }

    public function validateFilters() {

        return validator()->make($this->request->all(), $this->rules());

    }

    protected function rules() {
        return [
            'order_by' => 'required_with:order_direction|in:'.$this->orderableColumns(),
            'order_direction' => 'required_with:order_by|in:asc,desc',
            'limit' => 'sometimes|required|integer|min:1',

            // advanced filter
            'match_all' => 'sometimes|required|in:true,false',
            'filter' => 'sometimes|required|array',
            'f.*.column' => 'required|in:'.$this->orderableColumns(),
            'f.*.operator' => 'required_with:f.*.column|in:'.$this->allowedOperators(),
            'f.*.first_value' => 'required',
            'f.*.second_value' => 'required_if:f.*.operator,between,not_between'
        ];
    }


    protected function whiteListColumns()
    {
        return $this->allowedFilters;
    }
    protected function orderableColumns()
    {
        return $this->allowedFilters;
    }
    protected function allowedOperators()
    {
        return implode(',', config('operators.allowed-operators'));
    }

    public function setAllowedFilters($columns) {

        $this->allowedFilters = implode(',', $columns);
    }

}
