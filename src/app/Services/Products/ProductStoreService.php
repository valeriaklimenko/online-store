<?php

namespace App\Services\Products;

use App\Models\Product;
use App\Models\ProductImage;

class ProductStoreService
{
    public function store(array $data): Product
    {
        $images = $data['images'] ?? [];
        unset($data['images']);

        $product = Product::create($data);

        $storedImages = [];
        foreach ($images as $image) {
            $storedImages[] = [
                'product_id' => $product->id,
                'path' => $image->store('products', 'public'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($storedImages)) {
            ProductImage::insert($storedImages);
            $product->update([
                'image' => $storedImages[0]['path'],
            ]);
        }

        return $product->load('images');
    }
}
