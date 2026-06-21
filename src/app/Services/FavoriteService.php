<?php

namespace App\Services;

use App\Models\FavoriteItems;
use App\Models\Favorites;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FavoriteService
{
    /**
     * Get or create favorites for user
     */
    public function getForUser(User $user): Favorites
    {
        return Favorites::firstOrCreate(
            ['user_id' => $user->id]
        );
    }

    /**
     * Get or create favorites for current authenticated user
     */
    public function getForCurrentUser(): Favorites
    {
        $user = Auth::user();

        if (!$user) {
            throw new \RuntimeException('User not found');
        }

        /** @var User $user */
        return $this->getForUser($user);
    }

    /**
     * Prepare favorites data for view
     */
    public function getFavoritesData(Favorites $favorites): array
    {
        $items = $favorites->items()->with(['product.images', 'product.category', 'product.sizes'])->get();

        return [
            'favorites' => $favorites,
            'items' => $items,
        ];
    }

    /**
     * Remove favorite item by ID
     */
    public function removeItemById(Favorites $favorites, int $itemId): void
    {
        $favorites->items()
            ->where('id', $itemId)
            ->delete();
    }

    /**
     * Add product to favorites
     */
    public function addItem(Favorites $favorites, int $productId): FavoriteItems
    {

        $existingItem = FavoriteItems::where('favorite_id', $favorites->id)
            ->where('product_id', $productId)
            ->first();

        if ($existingItem) {
            return $existingItem->load('product');
        }

        $favoriteItem = FavoriteItems::create([
            'favorite_id' => $favorites->id,
            'product_id' => $productId,
        ]);

        return $favoriteItem->load('product');
    }
}
