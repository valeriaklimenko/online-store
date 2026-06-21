@php
    /** @var \Illuminate\Support\Collection<int, \App\Models\Category> $categories */

    $allCategory = ($categories ?? collect())->first(function ($category) {
        return strtolower((string) $category->slug) === 'all'
            || strtolower((string) $category->name) === 'all';
    });

    $menuCategories = $allCategory && ($allCategory->children ?? collect())->isNotEmpty()
        ? $allCategory->children
        : ($categories ?? collect());
@endphp

<div class="klavera-mega" role="menu">
    <div class="klavera-mega__inner">
        <h3 class="klavera-mega__heading">Categories</h3>
        <ul class="klavera-mega__roots" data-shop-category-list>
            @forelse($menuCategories as $category)
                @include('partials.storefront.category-nav-node', [
                    'category' => $category,
                    'activeCategory' => $activeCategory ?? null,
                    'level' => 0,
                ])
            @empty
                <li class="klavera-mega__empty">No categories yet</li>
            @endforelse
        </ul>
    </div>
</div>
