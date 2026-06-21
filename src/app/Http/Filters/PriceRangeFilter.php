<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class PriceRangeFilter implements ProductFilterInterface
{
    public function apply(Builder $query, mixed $value): Builder
    {
        $min = isset($value[0]) ? (float) $value[0] : 0;
        $max = isset($value[1]) ? (float) $value[1] : null;

        $query->where('price', '>=', $min);

        if ($max !== null && $max > 0) {
            $query->where('price', '<=', $max);
        }

        return $query;
    }
}
