<?php

namespace App\Http\Controllers\Category;

use App\Enums\FlashMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories
     */
    public function index(CategoryService $categoryService): View
    {
        $categories = $categoryService->getAllCategories();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category
     */
    public function create(CategoryService $categoryService): View
    {
        $categories = $categoryService->getAllCategories();
        return view('categories.create', compact('categories'));
    }

    /**
     * Store a newly created category
     */
    public function store(CategoryStoreRequest $request, CategoryService $categoryService): RedirectResponse
    {
        $categoryService->store($request->validated());

        return redirect()->route('categories.index')
            ->with('success', FlashMessage::CATEGORY_CREATED->value);
    }

    /**
     * Show the form for editing the specified category
     */
    public function edit(Category $category, CategoryService $categoryService): View
    {
        $categories = $categoryService->getAllCategories();
        return view('categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified category
     */
    public function update(CategoryUpdateRequest $request, Category $category, CategoryService $categoryService): RedirectResponse
    {
        $categoryId = (int) $category->id;
        $categoryService->update($categoryId, $request->validated());
        return redirect()->route('categories.index')
            ->with('success', FlashMessage::CATEGORY_UPDATED->value);
    }

    /**
     * Remove the specified category
     */
    public function destroy(Category $category, CategoryService $categoryService): RedirectResponse
    {
        try {
            $categoryService->delete($category);
        } catch (\RuntimeException $e) {
            return redirect()->route('categories.index')
                ->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->route('categories.index')
            ->with('success', FlashMessage::CATEGORY_DELETED->value);
    }
}
//пересмотреть
