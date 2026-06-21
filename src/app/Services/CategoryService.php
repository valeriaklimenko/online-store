<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use InvalidArgumentException;

class CategoryService
{
    private const int MAX_DEPTH = 100;

    /**
     * Get all categories with hierarchy
     */
    public function getAllCategories(int $perPage = 50): LengthAwarePaginator
    {
        return Category::with('parent')
            ->withCount('products')
            ->orderBy('name')
            ->paginate($perPage);
    }


    /**
     * Get root categories (categories without parent)
     */
    public function getRootCategories(): Collection
    {
        return Category::whereNull('parent_id')
            ->orderBy('name')
            ->get();
    }

    /**
     * Get categories with children for tree structure
     */
    public function getCategoriesTree(): Collection
    {
        $categories = Category::orderBy('name')->get();
        return $this->buildTree($categories);
    }

    /**
     * Get category by slug (sanitizes input)
     */
    public function getCategoryBySlug(string $slug): ?Category
    {
        $slug = strip_tags($slug);
        $slug = htmlspecialchars($slug, ENT_QUOTES, 'UTF-8');
        $slug = trim($slug);
        return Category::where('slug', $slug)->first();
    }

    /**
     * Get category by ID
     */
    public function getCategoryById(int $id): ?Category
    {
        $id = (int)$id;
        return Category::find($id);
    }

    /**
     * Get all category IDs including children (for filtering products)
     */
    public function getCategoryIdsWithChildren(?Category $category): array
    {
        if (!$category) {
            return [];
        }

        $allCategories = Category::select('id', 'parent_id')->get();
        return $this->buildDescendantIds($allCategories, $category->id);
    }

    private function buildDescendantIds(Collection $allCategories, int $parentId): array
    {
        $ids = [$parentId];
        $children = $allCategories->where('parent_id', $parentId);

        foreach ($children as $child) {
            $ids = array_merge($ids, $this->buildDescendantIds($allCategories, $child->id));
        }

        return $ids;
    }

    /**
     * Get categories formatted for select dropdown with hierarchy
     */
    public function getCategoriesForSelect(): array
    {
        $categories = $this->getAllCategories();
        $result = [];
        $this->buildSelectOptions($categories, null, $result, 0);
        return $result;
    }

    /**
     * Store a new category
     */
    public function store(array $data): Category
    {
        $data['name'] = $this->sanitizeInput($data['name'] ?? '');
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        } else {
            $data['slug'] = $this->sanitizeInput($data['slug']);
        }
        $existingCategory = Category::withTrashed()->where('slug', $data['slug'])->first();
        if ($existingCategory && $existingCategory->trashed()) {
            $existingCategory->restore();
            $existingCategory->update($data);
            return $existingCategory->fresh();
        }
        $data['slug'] = $this->ensureUniqueSlug($data['slug']);
        if (isset($data['parent_id'])) {
            $data['parent_id'] = $data['parent_id'] !== null ? (int)$data['parent_id'] : null;
        }
        return Category::create($data);
    }

    /**
     * Update a category
     */
    public function update(int $id, array $data): Category
    {
        $id = (int)$id;
        $category = Category::findOrFail($id);
        if (isset($data['name'])) {
            $data['name'] = $this->sanitizeInput($data['name']);
        }
        if (isset($data['parent_id'])) {
            $data['parent_id'] = $data['parent_id'] !== null ? (int)$data['parent_id'] : null;
            if ($data['parent_id'] !== null) {
                $this->validateNoCircularReference($category, $data['parent_id']);
            }
        }
        if (isset($data['name']) && empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        if (isset($data['slug'])) {
            $data['slug'] = $this->sanitizeInput($data['slug']);
            $data['slug'] = $this->ensureUniqueSlug($data['slug'], $category->id);
        }
        $category->update($data);
        return $category->fresh();
    }

    /**
     * Delete a category (soft delete)
     */
    public function delete(Category $category): bool
    {
        $categoryId = (int)$category->id;
        if (Category::where('parent_id', $categoryId)->whereNull('deleted_at')->exists()) {
            throw new \RuntimeException('Cannot delete category with child categories.');
        }
        if ($category->products()->exists()) {
            throw new \RuntimeException('Cannot delete category with associated products.');
        }
        return $category->delete();
    }

    private function buildTree(Collection $categories, ?int $parentId = null, int $depth = 0): Collection
    {
        if ($depth >= self::MAX_DEPTH) {
            throw new \RuntimeException('Maximum category tree depth exceeded. Possible circular reference.');
        }
        return $categories->filter(function ($category) use ($parentId) {
            $catParentId = $category->parent_id !== null ? (int)$category->parent_id : null;
            $filterParentId = $parentId !== null ? (int)$parentId : null;
            return $catParentId === $filterParentId;
        })->map(function ($category) use ($categories, $depth) {
            $category->children = $this->buildTree($categories, (int)$category->id, $depth + 1);
            return $category;
        });
    }

    private function buildSelectOptions($categories, ?int $parentId, array &$result, int $level): void
    {
        $children = $categories->where('parent_id', $parentId)->sortBy('order')->sortBy('name');
        foreach ($children as $category) {
            $prefix = $level > 0 ? str_repeat('— ', $level) : '';
            $result[$category->id] = $prefix . $category->name;
            $this->buildSelectOptions($categories, $category->id, $result, $level + 1);
        }
    }

    private function ensureUniqueSlug(string $slug, ?int $excludeId = null): string
    {
        $baseSlug = $slug;
        $counter = 1;
        $query = Category::where('slug', $slug);
        if ($excludeId !== null) {
            $query->where('id', '!=', $excludeId);
        }
        while ($query->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
            $query = Category::where('slug', $slug);
            if ($excludeId !== null) {
                $query->where('id', '!=', $excludeId);
            }
        }
        return $slug;
    }

    private function sanitizeInput(string $input): string
    {
        $sanitized = strip_tags($input);
        $sanitized = htmlspecialchars($sanitized, ENT_QUOTES, 'UTF-8');
        return trim($sanitized);
    }

    private function validateNoCircularReference(Category $category, int $newParentId): void
    {
        $newParentId = (int)$newParentId;
        $categoryId = (int)$category->id;
        if ($newParentId === $categoryId) {
            throw new InvalidArgumentException('Category cannot be its own parent');
        }
        $newParent = Category::findOrFail($newParentId);
        $descendants = $this->getDescendantIds($category);
        if (in_array($newParentId, $descendants, true)) {
            throw new InvalidArgumentException('Cannot set parent: would create circular reference');
        }
    }

    private function getDescendantIds(Category $category, int $depth = 0): array
    {
        if ($depth >= self::MAX_DEPTH) {
            throw new \RuntimeException('Maximum category tree depth exceeded. Possible circular reference.');
        }
        $categoryId = (int)$category->id;
        $ids = [];
        $children = Category::where('parent_id', $categoryId)->orderBy('name')->get();
        foreach ($children as $child) {
            $ids[] = (int)$child->id;
            $ids = array_merge($ids, $this->getDescendantIds($child, $depth + 1));
        }
        return $ids;
    }
}
