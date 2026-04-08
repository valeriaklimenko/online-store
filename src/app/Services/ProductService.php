<?php

namespace App\Services;

use App\Http\Filters\ProductFilterBuilder;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductQuantity;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function __construct(
        private ProductFilterBuilder $filterBuilder
    ) {}

    public function store(array $data): Product
    {
        return DB::transaction(function () use ($data) {
            $images = $data['images'] ?? [];
            unset($data['images']);

            $quantity = $data ['quantity'] ?? 0;
            unset($data['quantity']);

            $product = Product::create($data);

            if ($quantity > 0) {
                ProductQuantity::create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                ]);
            }

            $storedImages = [];
            foreach ($images as $image) {
                $storedImages[] = [
                    'product_id' => $product->id,
                    'path' => $image->store('products', 'public'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (!empty($storedImages)) {
                ProductImage::insert($storedImages);
                $product->update(['image' => $storedImages[0]['path']]);
            }

            return $product->load('images');
        });
    }

    public function update(int $id, array $data): bool
    {
        $id = (int)$id;

        return DB::transaction(function () use ($id, $data) {
            $product = Product::lockForUpdate()->findOrFail($id);

            $quantity = $data['quantity'] ?? 0;
            $newImages = $data['images'] ?? [];
            $removeImages = $data['remove_images'] ?? [];
            unset($data['images'], $data['remove_images']);

            if (!empty($removeImages)) {
                $removeImages = array_map('intval', $removeImages);
                $imagesToDelete = ProductImage::whereIn('id', $removeImages)
                    ->where('product_id', $product->id)
                    ->get();

                foreach ($imagesToDelete as $image) {
                    Storage::disk('public')->delete($image->path);
                    $image->delete();
                }
            }

            foreach ($newImages as $image) {
                $product->images()->create([
                    'path' => $image->store('products', 'public'),
                ]);
            }

            $firstImagePath = $product->images()->orderBy('id')->value('path');

            if ($firstImagePath !== null) {
                $data['image'] = $firstImagePath;
            } else {
                if (!isset($data['image'])) {
                    unset($data['image']);
                }
            }

            if ($quantity !== null) {
                $product->productQuantity()->updateOrCreate([
                    ['product_id' => $id],
                    ['quantity' => $quantity],
                ]);
            }


            return $product->update($data);
        });
    }

    public function delete(int $id): bool
    {
        $id = (int)$id;
        $product = Product::findOrFail($id);

        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        return $product->delete();
    }

    public function getPaginatedProducts(int $perPage = 15): LengthAwarePaginator
    {
        return Product::with(['images', 'category'])
            ->orderBy('name', 'asc')
            ->paginate($perPage);
    }

    public function getProductWithRelations(string $id): Product
    {
        return Product::with(['images', 'category'])->findOrFail($id);
    }

    public function getProductForEdit(string $id): Product
    {
        $id = (int)$id;
        return Product::with('images')->findOrFail($id);
    }

    public function searchProducts(array $params): LengthAwarePaginator
    {
        $query = Product::with(['images', 'category']);

        $filters = $this->prepareFilters($params);
        $query = $this->filterBuilder->apply($query, $filters);

        $allowedSortBy = ['name', 'price'];
        $allowedSortOrder = ['asc', 'desc'];

        $sortBy = (string)($params['sort_by'] ?? 'name');
        $sortOrder = strtolower((string)($params['sort_order'] ?? 'asc'));

        if (!in_array($sortBy, $allowedSortBy, true)) {
            $sortBy = 'name';
        }
        if (!in_array($sortOrder, $allowedSortOrder, true)) {
            $sortOrder = 'asc';
        }

        $query->orderBy($sortBy, $sortOrder);

        $perPage = (int)($params['per_page'] ?? 15);
        if ($perPage < 1) {
            $perPage = 15;
        }
        if ($perPage > 100) {
            $perPage = 100;
        }

        return $query->paginate($perPage);
    }

    protected function prepareFilters(array $params): array
    {
        $filters = [];

        if (!empty($params['query'])) {
            $filters['query'] = $params['query'];
        }

        if (!empty($params['category_id'])) {
            $filters['category_id'] = (int)$params['category_id'];
        }

        if (!empty($params['min_price']) || !empty($params['max_price'])) {
            $filters['price_range'] = [
                isset($params['min_price']) ? (float)$params['min_price'] : 0,
                isset($params['max_price']) ? (float)$params['max_price'] : null
            ];
        }

        return $filters;
    }

    public function buildSearchQuery(?string $searchQuery): Builder
    {
        $query = Product::with(['images', 'category']);

        if ($searchQuery) {
            $searchQueryLower = mb_strtolower($searchQuery);
            $query->where(function (Builder $q) use ($searchQueryLower) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $searchQueryLower . '%'])
                    ->orWhereRaw('LOWER(description) LIKE ?', ['%' . $searchQueryLower . '%']);
            });
        }

        return $query;
    }

    public function searchByName(string $query, int $limit = 6): Collection
    {
        $limit = (int)$limit;
        $queryLower = mb_strtolower($query);
        return Product::with(['images', 'category'])
            ->whereRaw('LOWER(name) LIKE ?', ['%' . $queryLower . '%'])
            ->orderBy('name', 'asc')
            ->limit($limit)
            ->get();
    }

    public function searchByNameAndDescription(string $query, int $limit = 6): Collection
    {
        $limit = (int)$limit;
        $queryLower = mb_strtolower($query);
        return Product::with(['images', 'category'])
            ->where(function (Builder $q) use ($queryLower) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $queryLower . '%'])
                    ->orWhereRaw('LOWER(description) LIKE ?', ['%' . $queryLower . '%']);
            })
            ->orderBy('name', 'asc')
            ->limit($limit)
            ->get();
    }

    public function getGalleryUrls(Product $product): SupportCollection
    {
        $galleryPaths = collect();

        if ($product->image) {
            $galleryPaths->push($product->image);
        }

        if ($product->images->count()) {
            $galleryPaths = $galleryPaths->merge($product->images->pluck('path'));
        }

        return $galleryPaths
            ->filter()
            ->unique()
            ->values()
            ->map(fn($path) => asset('storage/' . $path));
    }

    public function getCoverImage(?Product $product): ?string
    {
        if (!$product) {
            return null;
        }
        return $product->image ?? optional($product->images->first())->path;
    }
}
