<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ProductStoreRequest;
use App\Http\Requests\Products\ProductUpdateRequest;
use App\Services\Products\ProductDeleteService;
use App\Services\Products\ProductCategoryService;
use App\Services\Products\ProductListService;
use App\Services\Products\ProductStoreService;
use App\Services\Products\ProductUpdateService;
use App\Services\Products\ProductViewDataService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductListService $listService): View
    {
        $products = $listService->getPaginatedProducts();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ProductCategoryService $categoryService): View
    {
        $categories = $categoryService->getCategories();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request, ProductStoreService $storeService): RedirectResponse
    {
        $storeService->store($request->validated());
        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, ProductListService $listService, ProductViewDataService $viewDataService): View
    {
        $product = $listService->getProductWithRelations($id);
        $galleryUrls = $viewDataService->getGalleryUrls($product);
        return view('products.show', compact('product', 'galleryUrls'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, ProductListService $listService, ProductCategoryService $categoryService): View
    {
        $product = $listService->getProductForEdit($id);
        $categories = $categoryService->getCategories();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, string $id, ProductUpdateService $updateService): RedirectResponse
    {
        $updateService->update($id, $request->validated());
        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, ProductDeleteService $deleteService): RedirectResponse
    {
        $deleteService->delete($id);
        return redirect()->route('products.index')
            ->with('success', 'The product was successfully deleted');
    }
}
