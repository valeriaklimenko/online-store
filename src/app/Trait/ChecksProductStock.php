<?php

namespace App\Trait;

use App\Models\Product;

trait ChecksProductStock
{
    protected function checkStock(int $productId, int $sizeId, int $quantity): Product
    {
        $product = Product::with('sizes')->findOrFail($productId);

        $size = $product->sizes->firstWhere('id', $sizeId);

        if (!$size) {
            throw new \RuntimeException('Size not found for this product');
        }

        $availableQuantity = $size->pivot->quantity ?? 0;

        if ($availableQuantity < $quantity) {
            throw new \RuntimeException(
                sprintf('Not enough stock. Available: %d, Requested: %d', $availableQuantity, $quantity)
            );
        }

        return $product;
    }
}
