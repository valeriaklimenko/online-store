<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\SearchProductRequest;
use App\Models\CurrencyRate;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Contracts\View\View;

class WelcomeController extends Controller
{
    /**
     * Display the welcome / catalog page with products and categories.
     */
    public function index(
        SearchProductRequest $request,
        CategoryService $categoryService,
        ProductService $productService
    ): View {
        $validated = $request->validated();
        $categorySlug = $request->get('category');

        $activeCategory = null;
        if ($categorySlug) {
            $activeCategory = $categoryService->getCategoryBySlug($categorySlug);
            if ($activeCategory) {
                $validated['category_id'] = $activeCategory->id;
            }
        }

        $categoriesTree = $categoryService->getCategoriesTree();
        $allCategories = $categoryService->getAllCategories();

        if (!empty($validated['query']) || !empty($validated['category_id'])
            || !empty($validated['min_price']) || !empty($validated['max_price'])) {
            $products = $productService->searchProducts($validated);
        } else {
            $products = $productService->searchProducts(['per_page' => 15]);
        }

        $wantedCurrencyCodes = ['USD', 'EUR', 'RUB'];
        $currencyRates = CurrencyRate::query()
            ->whereIn('code', $wantedCurrencyCodes)
            ->get()
            ->keyBy('code');
        $currencyRatesUpdatedAt = $currencyRates->max('updated_at');

        return view('welcome', [
            'products' => $products,
            'categories' => $categoriesTree,
            'allCategories' => $allCategories,
            'activeCategory' => $activeCategory,
            'currencyRates' => $currencyRates,
            'currencyRatesUpdatedAt' => $currencyRatesUpdatedAt,
        ]);
    }
}
