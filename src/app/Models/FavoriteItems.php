<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FavoriteItems extends Model
{
    use HasFactory;

    protected $table = 'favorites_items';

    protected $fillable = [
        'favorite_id',
        'product_id',
    ];

    protected $with = ['product'];

    public function favorites(): BelongsTo
    {
        return $this->belongsTo(Favorites::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
