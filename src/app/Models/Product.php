<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'image',
        'is_new_collection',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_new_collection' => 'boolean',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function productQuantity(): HasOne
    {
        return $this->hasOne(ProductQuantity::class);
    }

    public function sizes(): HasMany
    {
        return $this->hasMany(ProductSize::class);
    }
}
