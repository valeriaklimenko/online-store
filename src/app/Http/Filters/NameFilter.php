<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class NameFilter implements ProductFilterInterface
{
    public function apply(Builder $query, mixed $value): Builder
    {
        return $query->where(function (Builder $q) use ($value) {
            $q->whereRaw('LOWER(name) LIKE ?', ['%' . mb_strtolower($value) . '%'])
              ->orWhereRaw('LOWER(description) LIKE ?', ['%' . mb_strtolower($value) . '%']);
        });
    }
}
