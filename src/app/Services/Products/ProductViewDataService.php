<?php

namespace App\Services\Products;

use App\Models\Product;
use Illuminate\Support\Collection;

class ProductViewDataService
{
    /**
     * Get gallery URLs for product view
     */
    public function getGalleryUrls(Product $product): Collection
    {
        $galleryPaths = collect();

        if ($product->image) {
            $galleryPaths->push($product->image);
        }

        if ($product->images->count()) {
            $galleryPaths = $galleryPaths->merge($product->images->pluck('path'));
        }

        return $galleryPaths
            ->filter()
            ->unique()
            ->values()
            ->map(fn ($path) => asset('storage/' . $path));
    }

    /**
     * Get cover image for product card
     */
    public function getCoverImage(?Product $product): ?string
    {
        if (!$product) {
            return null;
        }

        return $product->image ?? optional($product->images->first())->path;
    }
}
