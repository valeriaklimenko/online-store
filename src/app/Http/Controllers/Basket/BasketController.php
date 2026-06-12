<?php

namespace App\Http\Controllers\Basket;

use App\Enums\FlashMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Basket\BasketStoreRequest;
use App\Services\BasketService;
use App\Services\FavoriteService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class BasketController extends Controller
{
    /**
     * Display basket
     */
    public function index(BasketService $basketService): View
    {
        $basket = $basketService->getForCurrentUser();
        $data = $basketService->getBasketData($basket);
        return view('basket.index', compact('data'));
    }

    /**
     * Add product to basket
     */
    public function store(
        BasketStoreRequest $request,
        BasketService      $basketService
    ): RedirectResponse
    {
        $basket = $basketService->getForCurrentUser();
        $data = $request->validated();
        $productId = $data['product_id'];

        $basketService->addItem($basket, $productId);
        $basketService->updateTotal($basket);

        return redirect()->back()
            ->with('success', FlashMessage::BASKET_ADDED->value);
    }

    /**
     * Remove product from basket
     */
    public function destroy(int $id, BasketService $basketService): RedirectResponse
    {
        $basket = $basketService->getForCurrentUser();
        $basketService->removeItemById($basket, $id);
        $basketService->updateTotal($basket);
        return redirect()->route('basket.index')
            ->with('success', FlashMessage::BASKET_REMOVED->value);
    }
}
