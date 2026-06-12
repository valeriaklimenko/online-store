<?php

namespace App\Services;

use App\Models\Basket;
use App\Models\BasketItems;
use Illuminate\Support\Facades\Auth;

class BasketService
{
    /**
     * Calculate total cost of basket items
     */
    public function calculateTotal(Basket $basket): float
    {
        $total = 0;

        foreach ($basket->items()->with('product')->get() as $item) {
            $total += $item->product->price;
        }

        return round($total, 2);
    }

    /**
     * Update basket total price
     */
    public function updateTotal(Basket $basket): Basket
    {
        $basket->total_price = $this->calculateTotal($basket);
        $basket->save();

        return $basket;
    }

    /**
     * Prepare basket data for view
     */
    public function getBasketData(Basket $basket): array
    {
        $items = $basket->items()->with('product.images')->get();

        return [
            'basket' => $basket,
            'items' => $items,
            'total_price' => $basket->total_price,
            'items_count' => $items->count(),
        ];
    }

    /**
     * Get or create basket for user
     */
    public function getForUser($user): Basket
    {
        return Basket::firstOrCreate(
            ['user_id' => $user->id],
            ['total_price' => 0]
        );
    }

    /**
     * Get or create basket for current authenticated user
     */
    public function getForCurrentUser(): Basket
    {
        $user = Auth::user();

        if (!$user) {
            throw new \RuntimeException('User not authenticated');
        }

        return $this->getForUser($user);
    }

    /**
     * Remove basket item by ID
     */
    public function removeItemById(Basket $basket, int $itemId): void
    {
        $basket->items()
            ->where('id', $itemId)
            ->delete();
    }

    /**
     * Add product to basket
     */
    public function addItem(Basket $basket, int $productId): BasketItems
    {
        $existingItem = BasketItems::where('basket_id', $basket->id)
            ->where('product_id', $productId)
            ->first();

        if ($existingItem) {
            return $existingItem->load('product');
        }

        $basketItem = BasketItems::create([
            'basket_id' => $basket->id,
            'product_id' => $productId,
        ]);

        return $basketItem->load('product');
    }
}
