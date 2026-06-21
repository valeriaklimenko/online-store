<?php

namespace App\Http\Controllers\Product;

use App\Enums\FlashMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ProductStoreRequest;
use App\Http\Requests\Products\ProductUpdateRequest;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\ProductSizeService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductService $productService): View
    {
        $products = $productService->getPaginatedProducts();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CategoryService $categoryService, ProductSizeService $sizeService): View
    {
        $categories = $categoryService->getAllCategories();
        $allSizes = $sizeService->getCreateData();

        return view('products.create', array_merge(compact('categories'), $allSizes));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        ProductStoreRequest $request,
        ProductService      $productService,
        ProductSizeService  $sizeService
    ): RedirectResponse
    {
        $validated = $request->validated();
        $sizeQuantities = $validated['size_quantities'] ?? [];
        unset($validated['size_quantities']);

        $product = $productService->store($validated);

        $sizeService->syncSizes($product, $sizeQuantities);

        return redirect()->route('products.index')
            ->with('success', FlashMessage::PRODUCT_CREATED->value);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product, ProductService $productService): View
    {
        $product->load(['images', 'category', 'sizes']);
        $galleryUrls = $productService->getGalleryUrls($product);

        return view('products.show', compact('product', 'galleryUrls'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(
        Product            $product,
        CategoryService    $categoryService,
        ProductSizeService $sizeService,
    ): View
    {
        $product->load('images', 'sizes');
        $categories = $categoryService->getAllCategories();
        $sizeData = $sizeService->getEditData($product);

        return view('products.edit', array_merge(
            compact('product', 'categories'),
            $sizeData
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product, ProductService $productService): RedirectResponse
    {
        $productService->updateWithSizes($product->id, $request->validated());

        return redirect()->route('products.index')
            ->with('success', FlashMessage::PRODUCT_UPDATED->value);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, ProductService $productService): RedirectResponse
    {
        $productService->delete($product->id);

        return redirect()->route('products.index')
            ->with('success', FlashMessage::PRODUCT_DELETED->value);
    }
}
