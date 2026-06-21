<?php

namespace App\Services;

use App\Dto\Basket\AddItemDto;
use App\Models\Basket;
use App\Models\BasketItems;
use App\Trait\ChecksProductStock;
use Illuminate\Support\Facades\Auth;

class BasketService
{
    use ChecksProductStock;

    public function getBasket($user = null): Basket
    {
        $user = $user ?? Auth::user();

        if (!$user) {
            throw new \RuntimeException('User not logged in');
        }

        return Basket::firstOrCreate(
            ['user_id' => $user->id],
            ['total_price' => 0]
        );
    }

    public function addItem(Basket $basket, AddItemDto $dto): BasketItems
    {
        $this->checkStock($dto->productId, $dto->sizeId, $dto->quantity);

        $item = BasketItems::where('basket_id', $basket->id)
            ->where('product_id', $dto->productId)
            ->where('size_id', $dto->sizeId)
            ->first();

        if ($item) {
            $item->quantity += $dto->quantity;
            $item->save();
        } else {
            $item = BasketItems::create([
                'basket_id' => $basket->id,
                'product_id' => $dto->productId,
                'size_id' => $dto->sizeId,
                'quantity' => $dto->quantity,
            ]);
        }

        $this->updateTotal($basket);

        return $item->load(['product', 'size']);
    }

    public function updateItemQuantity(Basket $basket, int $itemId, int $quantity): BasketItems
    {
        return $this->updateItem($basket, $itemId, $quantity);
    }

    public function removeItem(Basket $basket, int $itemId): void
    {
        $basket->items()->where('id', $itemId)->delete();
        $this->updateTotal($basket);
    }

    public function updateTotal(Basket $basket): Basket
    {
        $total = $basket->items()
            ->with('product')
            ->get()
            ->sum(fn($item) => $item->product->price * $item->quantity);

        $basket->total_price = round($total, 2);
        $basket->save();

        return $basket;
    }

    public function getBasketData(Basket $basket): array
    {
        $items = $basket->items()
            ->with(['product.images', 'size'])
            ->get();

        return [
            'items' => $items,
            'total_price' => $basket->total_price,
            'items_count' => $items->sum('quantity'),
        ];
    }

    private function getItem(Basket $basket, int $itemId): BasketItems
    {
        return BasketItems::where('basket_id', $basket->id)
            ->findOrFail($itemId);
    }

    private function updateItem(Basket $basket, int $itemId, int $quantity): BasketItems
    {
        $item = $this->getItem($basket, $itemId);

        if ($quantity <= 0) {
            $item->delete();
            $this->updateTotal($basket);
            throw new \RuntimeException('Item removed from basket');
        }

        $this->checkStock($item->product_id, $item->size_id, $quantity);

        $item->quantity = $quantity;
        $item->save();

        $this->updateTotal($basket);

        return $item->load(['product', 'size']);
    }
}
