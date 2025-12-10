@extends('layouts.app')

@section('title', $product->name . ' — Klavera')

@section('content')
    <a href="{{ url('/#products') }}" class="pill-btn" style="margin-bottom: 1.5rem; display: inline-flex;">← Назад к каталогу</a>

    <section class="card product-detail">
        <div>
            @if($galleryUrls->isNotEmpty())
                <div
                    class="media-slider"
                    data-images='@json($galleryUrls, JSON_UNESCAPED_SLASHES)'
                >
                    <img
                        src="{{ $galleryUrls->first() }}"
                        alt="{{ $product->name }}"
                        data-media-image
                    >
                    <button
                        class="media-nav media-nav--prev"
                        type="button"
                        aria-label="Предыдущая фотография"
                        data-media-prev
                        @if($galleryUrls->count() <= 1) hidden @endif
                    >
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M15 6l-6 6 6 6"/>
                        </svg>
                    </button>
                    <button
                        class="media-nav media-nav--next"
                        type="button"
                        aria-label="Следующая фотография"
                        data-media-next
                        @if($galleryUrls->count() <= 1) hidden @endif
                    >
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6"/>
                        </svg>
                    </button>
                </div>
            @else
                <figure class="media-placeholder">📦</figure>
            @endif
        </div>
        <div class="product-summary">
            <p class="overline">Klavera / Товар</p>
            <h1 style="font-family: 'Playfair Display', serif; font-size: 2.25rem;">{{ $product->name }}</h1>
            <p style="color: var(--text-muted);">
                {{ $product->description ?? 'Описание появится позже.' }}
            </p>
            <div>
                <div class="product-price">${{ number_format($product->price, 2) }}</div>
                <p class="product-meta">В наличии: {{ $product->quantity }}</p>
                @if($product->category)
                    <p class="product-meta">Категория: {{ $product->category->name }}</p>
                @endif
            </div>
            <div class="product-actions">
                <button
                    class="btn btn-primary"
                    id="detailCartBtn"
                    data-product-id="{{ $product->id }}"
                >
                    В корзину
                </button>
                <button
                    class="favorite-toggle"
                    id="detailFavoriteBtn"
                    aria-label="Добавить в избранное"
                    data-product-id="{{ $product->id }}"
                >
                    <svg viewBox="0 0 24 24">
                        <path d="M12 20.5s-6.2-3.9-8.5-7.2c-1.6-2.3-1.7-5.3 0.2-7.1a4.3 4.3 0 0 1 5.8.3l2.5 2.5 2.5-2.5a4.3 4.3 0 0 1 5.8-.3c1.9 1.8 1.8 4.8 0.2 7.1-2.3 3.3-8.5 7.2-8.5 7.2z"/>
                    </svg>
                </button>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const favoriteStorageKey = 'klavera:favorites';
        const cartStorageKey = 'klavera:cart';

        const parseStoredSet = (key) => {
            try {
                return new Set(JSON.parse(localStorage.getItem(key) || '[]'));
            } catch (error) {
                console.warn('Storage parse error', error);
                return new Set();
            }
        };

        const persistSet = (key, set) => {
            localStorage.setItem(key, JSON.stringify([...set]));
        };

        const favorites = parseStoredSet(favoriteStorageKey);
        const cartItems = parseStoredSet(cartStorageKey);

        const favoriteBtn = document.getElementById('detailFavoriteBtn');
        const cartBtn = document.getElementById('detailCartBtn');

        if (favoriteBtn) {
            const productId = favoriteBtn.dataset.productId;
            if (favorites.has(productId)) {
                favoriteBtn.classList.add('is-active');
            }
            favoriteBtn.addEventListener('click', () => {
                if (favorites.has(productId)) {
                    favorites.delete(productId);
                    favoriteBtn.classList.remove('is-active');
                } else {
                    favorites.add(productId);
                    favoriteBtn.classList.add('is-active');
                }
                persistSet(favoriteStorageKey, favorites);
            });
        }

        if (cartBtn) {
            const productId = cartBtn.dataset.productId;
            const isAuthenticated = @json(auth()->check());
            
            const updateCartState = (added) => {
                cartBtn.textContent = added ? 'В корзине' : 'В корзину';
                cartBtn.classList.toggle('btn-ghost', added);
            };

            updateCartState(cartItems.has(productId));

            cartBtn.addEventListener('click', () => {
                // Проверка авторизации
                if (!isAuthenticated) {
                    alert('Чтобы добавить товар в корзину, необходимо авторизоваться');
                    window.location.href = '{{ route("login") }}';
                    return;
                }

                if (cartItems.has(productId)) {
                    cartItems.delete(productId);
                    updateCartState(false);
                } else {
                    cartItems.add(productId);
                    updateCartState(true);
                }
                persistSet(cartStorageKey, cartItems);
            });
        }

        document.querySelectorAll('.media-slider').forEach((slider) => {
            const rawImages = slider.dataset.images || '[]';
            let images = [];
            try {
                images = JSON.parse(rawImages);
            } catch (error) {
                console.warn('Slider data parse error', error);
            }

            if (!images.length) {
                return;
            }

            const imageEl = slider.querySelector('[data-media-image]');
            const prevBtn = slider.querySelector('[data-media-prev]');
            const nextBtn = slider.querySelector('[data-media-next]');
            let currentIndex = 0;

            const updateImage = () => {
                if (!imageEl) {
                    return;
                }
                imageEl.src = images[currentIndex];
            };

            if (images.length <= 1) {
                prevBtn?.setAttribute('hidden', 'true');
                nextBtn?.setAttribute('hidden', 'true');
                return;
            }

            prevBtn?.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                updateImage();
            });

            nextBtn?.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % images.length;
                updateImage();
            });
        });
    </script>
@endpush

