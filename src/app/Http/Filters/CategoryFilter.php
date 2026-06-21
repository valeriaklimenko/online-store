<?php

namespace App\Http\Filters;

use App\Services\CategoryService;
use Illuminate\Database\Eloquent\Builder;

class CategoryFilter implements ProductFilterInterface
{
    public function __construct(
        private readonly CategoryService $categoryService
    ) {}

    public function apply(Builder $query, mixed $value): Builder
    {
        $categoryId = (int) $value;
        $category = $this->categoryService->getCategoryById($categoryId);

        if ($category) {
            $categoryIds = $this->categoryService->getCategoryIdsWithChildren($category);
            $categoryIds = array_map('intval', $categoryIds);
            return $query->whereIn('category_id', $categoryIds);
        }

        return $query->where('category_id', $categoryId);
    }
}
