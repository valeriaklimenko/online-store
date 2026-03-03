@php
    $hasChildren = isset($category->children) && is_countable($category->children) && count($category->children) > 0;
    $isActive = $activeCategory && $activeCategory->id == $category->id;
@endphp

<div class="catalog-category-item">
    @if($hasChildren)
        <div class="catalog-item-wrapper">
            <a href="{{ route('home', ['category' => $category->slug]) }}"
               class="catalog-item {{ $isActive ? 'is-active' : '' }}">
                {{ $category->name }}
            </a>
            <button type="button" class="category-toggle" data-has-children="true">
                <svg class="category-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 18l6-6-6-6"/>
                </svg>
            </button>
        </div>
    @else
        <a href="{{ route('home', ['category' => $category->slug]) }}"
           class="catalog-item {{ $isActive ? 'is-active' : '' }}">
            {{ $category->name }}
        </a>
    @endif

    @if($hasChildren)
        <div class="subcategories-dropdown">
            @foreach($category->children as $child)
                @include('partials.catalog-category', ['category' => $child, 'categories' => $categories, 'activeCategory' => $activeCategory])
            @endforeach
        </div>
    @endif
</div>
