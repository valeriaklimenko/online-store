<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class ProductFilterBuilder
{
    protected array $filters = [];

    public function __construct()
    {
        $this->filters = [
            'query' => NameFilter::class,
            'category_id' => CategoryFilter::class,
            'price_range' => PriceRangeFilter::class,
        ];
    }

    public function apply(Builder $query, array $params): Builder
    {
        foreach ($params as $key => $value) {
            if (isset($this->filters[$key]) && !empty($value)) {
                $filterClass = $this->filters[$key];
                $filter = app($filterClass);
                $query = $filter->apply($query, $value);
            }
        }

        return $query;
    }
}
