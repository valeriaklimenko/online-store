<?php

namespace App\Services\Products;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductUpdateService
{
    public function update(string $id, array $data): bool
    {
        $product = Product::findOrFail($id);

        $newImages = $data['images'] ?? [];
        $removeImages = $data['remove_images'] ?? [];
        unset($data['images'], $data['remove_images']);

        if (!empty($removeImages)) {
            $imagesToDelete = ProductImage::whereIn('id', $removeImages)
                ->where('product_id', $product->id)
                ->get();

            foreach ($imagesToDelete as $image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }
        }

        foreach ($newImages as $image) {
            $product->images()->create([
                'path' => $image->store('products', 'public'),
            ]);
        }

        $firstImagePath = $product->images()->orderBy('id')->value('path');
        $data['image'] = $firstImagePath;

        return $product->update($data);
    }
}
