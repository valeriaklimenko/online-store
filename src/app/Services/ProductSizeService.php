<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Sizes;

class ProductSizeService
{
    public function getAllSizes(): array
    {
        return Sizes::orderBy('code')->get()->toArray();
    }

    public function syncSizes(Product $product, array $sizeQuantities): void
    {
        if (empty($sizeQuantities)) {
            return;
        }

        $syncData = [];
        foreach ($sizeQuantities as $sizeId => $quantity) {
            $syncData[$sizeId] = ['quantity' => (int) $quantity];
        }

        $product->sizes()->sync($syncData);
    }

    public function getCreateData(): array
    {
        return [
            'allSizes' => Sizes::orderBy('name')->get(),
            'sizeQuantities' => [],
        ];
    }

    public function getEditData(Product $product): array
    {
        $sizeQuantities = [];
        foreach ($product->sizes as $size) {
            $sizeQuantities[$size->id] = $size->pivot->quantity ?? 0;
        }

        return [
            'allSizes' => Sizes::orderBy('name')->get(),
            'sizeQuantities' => $sizeQuantities,
        ];
    }
}
