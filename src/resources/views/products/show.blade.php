@extends('layouts.app')

@section('title', $product->name . ' — Klavera')

@section('content')
    <a href="{{ route('home') }}#products" class="btn btn-ghost" style="margin-bottom: 1.5rem;">← Back to catalog</a>

    <section class="card product-detail">
        <div>
            @if($galleryUrls->isNotEmpty())
                <div class="media-slider" data-images='@json($galleryUrls, JSON_UNESCAPED_SLASHES)'>
                    <img src="{{ $galleryUrls->first() }}" alt="{{ $product->name }}" data-media-image>
                    <button class="media-nav media-nav--prev" type="button" aria-label="Previous photo" data-media-prev
                            @if($galleryUrls->count() <= 1) hidden @endif>
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                  stroke-linejoin="round" d="M15 6l-6 6 6 6"/>
                        </svg>
                    </button>
                    <button class="media-nav media-nav--next" type="button" aria-label="Next photo" data-media-next
                            @if($galleryUrls->count() <= 1) hidden @endif>
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                  stroke-linejoin="round" d="M9 6l6 6-6 6"/>
                        </svg>
                    </button>
                </div>
            @else
                <figure class="media-placeholder">📦</figure>
            @endif
        </div>
        <div class="product-summary">
            <p class="overline">Klavera / Product</p>
            <h1>{{ $product->name }}</h1>
            <p style="color: var(--text-muted);">
                {{ $product->description ?? 'Description coming soon.' }}
            </p>
            <div>
                <div class="product-price">${{ number_format($product->price, 2) }}</div>
                @if($product->category)
                    <p class="product-meta">Category: {{ $product->category->name }}</p>
                @endif
            </div>
            <div class="product-actions">
                <div class="product-sizes">
                    <label>SIZE:</label>
                    <div class="sizes-list">
                        @foreach($product->sizes as $s)
                            @php $isAvailable = ($s->pivot->quantity ?? 0) > 0; @endphp
                            <button type="button"
                                    class="size-option {{ $isAvailable ? '' : 'unavailable' }}"
                                    data-size-id="{{ $s->id }}"
                                @disabled(!$isAvailable)>
                                {{ $s->name }}
                            </button>
                        @endforeach
                        <a href="#" id="sizeGuideLink" class="size-guide">Size Guide</a>
                    </div>
                    <p class="product-inline-warning" id="sizeWarning" hidden>Please select a size before adding this
                        item to your basket.</p>
                </div>

                <button class="btn btn-primary" id="detailCartBtn" data-product-id="{{ $product->id }}">
                    Add to Cart
                </button>
                <button class="favorite-toggle" id="detailFavoriteBtn" aria-label="Add to favorites"
                        data-product-id="{{ $product->id }}">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M12 20.5s-6.2-3.9-8.5-7.2c-1.6-2.3-1.7-5.3 0.2-7.1a4.3 4.3 0 0 1 5.8.3l2.5 2.5 2.5-2.5a4.3 4.3 0 0 1 5.8-.3c1.9 1.8 1.8 4.8 0.2 7.1-2.3 3.3-8.5 7.2-8.5 7.2z"/>
                    </svg>
                </button>
            </div>
        </div>
    </section>

    @include('partials.size-guide-modal')
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const isAuthenticated = @json(auth()->check());
            const favoriteBtn = document.getElementById('detailFavoriteBtn');
            const cartBtn = document.getElementById('detailCartBtn');

            if (favoriteBtn) {
                const productId = favoriteBtn.dataset.productId;

                if (isAuthenticated) {
                    fetch('{{ route("favorites.index") }}')
                        .then(r => r.text())
                        .then(html => {
                            const doc = new DOMParser().parseFromString(html, 'text/html');
                            if (doc.querySelector(`a[href*="/products/${productId}"]`)) {
                                favoriteBtn.classList.add('is-active');
                            }
                        })
                        .catch(() => {
                        });
                }

                favoriteBtn.addEventListener('click', () => {
                    if (!isAuthenticated) {
                        window.location.href = '{{ route("loginForm") }}';
                        return;
                    }

                    const isActive = favoriteBtn.classList.contains('is-active');
                    favoriteBtn.disabled = true;
                    const formData = new FormData();
                    formData.append('product_id', productId);
                    formData.append('_token', '{{ csrf_token() }}');

                    fetch(isActive ? '{{ route("favorites.removeByProduct") }}' : '{{ route("favorites.store") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json'},
                    })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) favoriteBtn.classList.toggle('is-active', !isActive);
                            favoriteBtn.disabled = false;
                        })
                        .catch(() => {
                            favoriteBtn.disabled = false;
                        });
                });
            }

            if (cartBtn) {
                const productId = cartBtn.dataset.productId;
                let selectedSizeId = null;

                document.querySelectorAll('.size-option').forEach(btn => {
                    btn.addEventListener('click', () => {
                        document.querySelectorAll('.size-option').forEach(b => b.classList.remove('is-active'));
                        btn.classList.add('is-active');
                        selectedSizeId = btn.dataset.sizeId;
                        document.getElementById('sizeWarning')?.setAttribute('hidden', 'hidden');
                    });
                });

                const sizeGuideModal = document.getElementById('sizeGuideModal');
                const sizeGuideLink = document.getElementById('sizeGuideLink');
                if (sizeGuideLink && sizeGuideModal) {
                    sizeGuideLink.addEventListener('click', e => {
                        e.preventDefault();
                        sizeGuideModal.classList.add('active');
                    });
                    sizeGuideModal.querySelectorAll('[data-modal-close]').forEach(el => {
                        el.addEventListener('click', () => sizeGuideModal.classList.remove('active'));
                    });
                }

                cartBtn.addEventListener('click', () => {
                    if (!isAuthenticated) {
                        window.location.href = '{{ route("loginForm") }}';
                        return;
                    }
                    if (!selectedSizeId) {
                        const warning = document.getElementById('sizeWarning');
                        warning?.removeAttribute('hidden');
                        warning?.scrollIntoView({block: 'nearest', behavior: 'smooth'});
                        return;
                    }

                    cartBtn.disabled = true;
                    const formData = new FormData();
                    formData.append('product_id', productId);
                    formData.append('size_id', selectedSizeId);
                    formData.append('quantity', '1');
                    formData.append('_token', '{{ csrf_token() }}');

                    fetch('{{ route("basket.store") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json'},
                    })
                        .then(async r => {
                            const data = await r.json().catch(() => ({}));
                            if (!r.ok) throw new Error(data.message || 'Failed to add to cart');
                            return data;
                        })
                        .then(data => {
                            if (data.success) window.location.href = '{{ route("basket.index") }}';
                        })
                        .catch(err => {
                            const warning = document.getElementById('sizeWarning');
                            if (warning) {
                                warning.textContent = err.message || 'Could not add this item to your basket. Please try again.';
                                warning.removeAttribute('hidden');
                            }
                            cartBtn.disabled = false;
                        });
                });
            }

            document.querySelectorAll('.media-slider').forEach(slider => {
                let images = [];
                try {
                    images = JSON.parse(slider.dataset.images || '[]');
                } catch (_) {
                }
                if (images.length <= 1) return;

                const imageEl = slider.querySelector('[data-media-image]');
                let currentIndex = 0;
                slider.querySelector('[data-media-prev]')?.addEventListener('click', () => {
                    currentIndex = (currentIndex - 1 + images.length) % images.length;
                    if (imageEl) imageEl.src = images[currentIndex];
                });
                slider.querySelector('[data-media-next]')?.addEventListener('click', () => {
                    currentIndex = (currentIndex + 1) % images.length;
                    if (imageEl) imageEl.src = images[currentIndex];
                });
            });
        });
    </script>
@endpush
