<?php

namespace App\Http\Controllers\Basket;

use App\Dto\Basket\AddItemDto;
use App\Enums\FlashMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Basket\BasketStoreRequest;
use App\Http\Requests\Basket\BasketUpdateRequest;
use App\Services\BasketService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class BasketController extends Controller
{
    public function index(BasketService $basketService): View
    {
        $basket = $basketService->getBasket();
        $data = $basketService->getBasketData($basket);

        return view('basket.index', compact('data'));
    }

    public function store(BasketStoreRequest $request, BasketService $basketService): JsonResponse|RedirectResponse
    {
        $basket = $basketService->getBasket();
        $basketService->addItem($basket, new AddItemDto($request->validated()));

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => FlashMessage::BASKET_ADDED->value,
            ]);
        }

        return redirect()->back()
            ->with('success', FlashMessage::BASKET_ADDED->value);
    }

    public function update(BasketUpdateRequest $request, int $ItemId, BasketService $basketService): RedirectResponse
    {
        $basket = $basketService->getBasket();
        $basketService->updateItemQuantity($basket, $ItemId, $request->input('quantity'));

        return redirect()->route('basket.index')
            ->with('success', FlashMessage::BASKET_UPDATED->value);
    }

    public function destroy(int $id, BasketService $basketService): RedirectResponse
    {
        $basket = $basketService->getBasket();
        $basketService->removeItem($basket, $id);
        $basketService->updateTotal($basket);

        return redirect()->route('basket.index')
            ->with('success', FlashMessage::BASKET_REMOVED->value);
    }
}
