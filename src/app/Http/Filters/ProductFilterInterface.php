<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

interface ProductFilterInterface
{
    public function apply(Builder $query, mixed $value): Builder;
}
