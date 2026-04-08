<?php

namespace App\Http\Controllers\Product;

use App\Enums\FlashMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ProductStoreRequest;
use App\Http\Requests\Products\ProductUpdateRequest;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\ProductService;
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
    public function create(CategoryService $categoryService): View
    {
        $categories = $categoryService->getAllCategories();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request, ProductService $productService): RedirectResponse
    {
        $productService->
        store($request->validated());
        return redirect()->route('products.index')
            ->with('success', FlashMessage::PRODUCT_CREATED->value);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product, ProductService $productService): View
    {
        $product->load(['images', 'category']);
        $galleryUrls = $productService->getGalleryUrls($product);
        return view('products.show', compact('product', 'galleryUrls'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, CategoryService $categoryService): View
    {
        $product->load('images');
        $categories = $categoryService->getAllCategories();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product, ProductService $productService): RedirectResponse
    {
        $productId = (int) $product->id;
        $productService->update($productId, $request->validated());
        return redirect()->route('products.index')
            ->with('success', FlashMessage::PRODUCT_UPDATED->value);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, ProductService $productService): RedirectResponse
    {
        $productId = (int) $product->id;
        $productService->delete($productId);
        return redirect()->route('products.index')
            ->with('success', FlashMessage::PRODUCT_DELETED->value);
    }
}
