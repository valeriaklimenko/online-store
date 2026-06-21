<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Sizes extends Model
{
    protected $table = 'clothes_sizes';

    protected $fillable = [
        'name',
        'code'
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'clothes_sizes', 'size_id', 'product_id')
            ->withPivot('quantity');
    }
}
