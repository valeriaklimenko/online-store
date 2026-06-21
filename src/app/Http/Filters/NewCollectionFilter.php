<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class NewCollectionFilter implements ProductFilterInterface
{
    public function apply(Builder $query, mixed $value): Builder
    {
        return $query->where('is_new_collection', (bool) $value);
    }
}
