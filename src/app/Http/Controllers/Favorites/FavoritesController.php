<?php

namespace App\Http\Controllers\Favorites;

use App\Enums\FlashMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Favorite\FavoriteStoreRequest;
use App\Services\FavoriteService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    /**
     * Display favorites
     */
    public function index(FavoriteService $favoriteService): View
    {
        $favorites = $favoriteService->getForCurrentUser();
        $data = $favoriteService->getFavoritesData($favorites);
        return view('favorites.index', compact('data'));
    }

    /**
     * Add product to favorites
     */
    public function store(FavoriteStoreRequest $request, FavoriteService $favoriteService): JsonResponse|RedirectResponse
    {
        $favorites = $favoriteService->getForCurrentUser();
        $favoriteService->addItem($favorites, $request->validated()['product_id']);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => FlashMessage::FAVORITES_ADDED->value,
            ]);
        }

        return redirect()->back()
            ->with('success', FlashMessage::FAVORITES_ADDED->value);
    }

    /**
     * Remove product from favorites by item ID
     */
    public function destroy(int $id, FavoriteService $favoriteService): RedirectResponse
    {
        $favorites = $favoriteService->getForCurrentUser();
        $favoriteService->removeItemById($favorites, $id);
        return redirect()->route('favorites.index')
            ->with('success', FlashMessage::FAVORITES_REMOVED->value);
    }
}
