<?php

namespace WayneCook\LaraFilter;

class CustomQueryBuilder {

    private $query;
    private $filter;
    private $config;

    public function __construct($query, $filter, $config)
    {
        $this->query = $query;
        $this->filter = $filter;
        $this->config = $config;
    }

    public function apply()
    {
        if ($this->filter) {
            foreach ($this->config as $filter) {
                $this->query->orWhere($filter, 'like', "%" . $this->filter['keyword'] ."%");
            }
        }
        return $this->query;
    }
}
