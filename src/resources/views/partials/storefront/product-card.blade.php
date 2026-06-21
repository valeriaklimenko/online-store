@php
    /** @var \App\Models\Product $productItem */
    $cover = $productItem->image ?? optional($productItem->images->first())->path;
@endphp

<article class="klavera-card" data-detail-url="{{ route('products.show', $productItem->id) }}" tabindex="0">
    <div class="klavera-card__media">
        <button
            class="klavera-card__fav"
            type="button"
            aria-label="Add to favorites"
            aria-pressed="false"
            data-product-id="{{ $productItem->id }}"
        >
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 20.5s-6.2-3.9-8.5-7.2c-1.6-2.3-1.7-5.3 0.2-7.1a4.3 4.3 0 0 1 5.8.3l2.5 2.5 2.5-2.5a4.3 4.3 0 0 1 5.8-.3c1.9 1.8 1.8 4.8 0.2 7.1-2.3 3.3-8.5 7.2-8.5 7.2z"/>
            </svg>
        </button>
        @if($cover)
            <img src="{{ asset('storage/' . $cover) }}" alt="{{ $productItem->name }}" loading="lazy">
        @endif
    </div>
    <div class="klavera-card__meta">
        <h3 class="klavera-card__name">{{ $productItem->name }}</h3>
        <span class="klavera-card__price">${{ number_format($productItem->price, 0) }}</span>
        @if($productItem->category)
            <p class="klavera-card__variant">{{ $productItem->category->name }}</p>
        @endif
    </div>
</article>
