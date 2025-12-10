<?php

namespace App\Services\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductDeleteService
{
    public function delete(string $id): bool
    {
        $product = Product::findOrFail($id);

        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        return $product->delete();
    }
}
