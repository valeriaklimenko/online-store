<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'order',
    ];

    protected static function booted(): void
    {
        static::saving(function (Category $category) {
            if (isset($category->name)) {
                $category->name = strip_tags($category->name);
                $category->name = htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8');
                $category->name = trim($category->name);
            }

            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            } else {
                $category->slug = strip_tags($category->slug);
                $category->slug = htmlspecialchars($category->slug, ENT_QUOTES, 'UTF-8');
                $category->slug = trim($category->slug);
            }
        });
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id')
            ->whereNull('deleted_at');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')
            ->whereNull('deleted_at');
    }

    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
