<?php

namespace App\Services\Products;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductListService
{
    /**
     * Get paginated list of products with relations
     */
    public function getPaginatedProducts(int $perPage = 15): LengthAwarePaginator
    {
        return Product::with(['images', 'category'])
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get single product with relations
     */
    public function getProductWithRelations(string $id): Product
    {
        return Product::with(['images','category'])->findOrFail($id);
    }

    /**
     * Get product for editing
     */
    public function getProductForEdit(string $id): Product
    {
        return Product::with('images')->findOrFail($id);
    }
}
