<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klavera - Women's Fashion Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
            <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --page-bg: #f5f5f5;
            --surface: #ffffff;
            --text-main: #101010;
            --text-muted: #6a6a6a;
            --text-gray: #6a6a6a;
            --line: #e5e5e5;
            --accent: #111111;
            --accent-hover: #000000;
            --accent-soft: #e8e8e8;
            --favorite: #f44336;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            background: var(--page-bg);
            line-height: 1.6;
        }

        img {
            max-width: 100%;
            display: block;
        }

        button {
            font-family: inherit;
        }

        /* Header */
        header {
            background: var(--surface);
            border-bottom: 1px solid var(--line);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 0.75rem 0;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }

        .logo img {
            width: 44px;
            height: 44px;
            object-fit: contain;
        }

        .catalog-section {
            position: relative;
        }

        .catalog-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.55rem 1rem;
            border: 1px solid var(--line);
            border-radius: 999px;
            background: transparent;
            cursor: pointer;
            transition: border-color 0.25s ease, color 0.25s ease;
            font-weight: 500;
        }

        .catalog-btn .menu-toggle {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .catalog-btn .menu-toggle span {
            width: 18px;
            height: 2px;
            background: var(--text-main);
        }

        .catalog-btn:hover {
            border-color: var(--text-main);
            color: var(--text-main);
        }

        .search-bar {
            flex: 1;
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-bar input {
            width: 100%;
            padding: 0.65rem 2.75rem 0.65rem 1.25rem;
            border-radius: 999px;
            border: 1px solid var(--line);
            background: var(--surface);
            font-size: 0.95rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .search-bar input:focus {
            outline: none;
            border-color: var(--text-main);
            box-shadow: 0 0 0 3px rgba(0,0,0,0.05);
        }

        .search-icon-btn {
            position: absolute;
            right: 6px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: none;
            background: var(--accent);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.2s ease;
        }

        .search-icon-btn:hover {
            background: var(--accent-hover);
            transform: scale(1.03);
        }

        .search-icon-btn svg {
            width: 18px;
            height: 18px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .profile-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 1px solid var(--line);
            background: var(--surface);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--text-main);
            text-decoration: none;
            transition: border-color 0.2s ease;
        }

        .profile-icon:hover {
            border-color: var(--text-main);
        }

        /* Dropdown Catalog */
        .catalog-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 1rem;
            width: 260px;
            box-shadow: 0 12px 40px rgba(0,0,0,0.08);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-6px);
            transition: opacity 0.2s ease, transform 0.2s ease;
            z-index: 10;
        }

        .catalog-dropdown.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .catalog-grid {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .catalog-item {
            display: block;
            color: inherit;
            text-decoration: none;
            padding: 0.45rem 0.75rem;
            border-radius: 8px;
            font-size: 0.95rem;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .catalog-item:hover {
            background: var(--accent-soft);
        }

        .catalog-item.is-active {
            background: var(--text-main);
            color: var(--surface);
        }

        /* Hero Section */
        .hero {
            max-width: 1200px;
            margin: 2.5rem auto 2rem;
            padding: 3.5rem 1.75rem;
            border-radius: 28px;
            background: var(--surface);
            border: 1px solid var(--line);
            text-align: center;
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 4vw, 3rem);
            margin-bottom: 1rem;
            color: var(--text-main);
        }

        .hero p {
            max-width: 520px;
            margin: 0 auto 2rem;
            color: var(--text-muted);
            font-size: 1rem;
        }

        .hero-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: 0.85rem 2.25rem;
            text-decoration: none;
            background: var(--accent);
            color: #fff;
            font-weight: 600;
            transition: background 0.2s ease, transform 0.2s ease;
        }

        .hero-btn:hover {
            background: var(--accent-hover);
            transform: translateY(-2px);
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.25rem;
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .section-subtitle {
            text-align: center;
            color: var(--text-muted);
            margin-top: -1.5rem;
            margin-bottom: 2rem;
        }

        /* Products */
        .products {
            max-width: 1200px;
            margin: 0 auto 4rem;
            padding: 0 1.5rem;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1.5rem;
        }

        .product-card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            position: relative;
        }

        .product-card:hover,
        .product-card:focus-within {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }

        .favorite-btn {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 1px solid rgba(16,16,16,0.15);
            background: rgba(255,255,255,0.8);
            backdrop-filter: blur(4px);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: border-color 0.2s ease, transform 0.2s ease, background 0.2s ease;
        }

        .favorite-btn svg {
            width: 18px;
            height: 18px;
            fill: transparent;
            stroke: var(--text-main);
            stroke-width: 1.5;
        }

        .favorite-btn.is-active {
            border-color: var(--favorite);
            background: rgba(244,67,54,0.1);
        }

        .favorite-btn.is-active svg {
            fill: var(--favorite);
            stroke: var(--favorite);
        }

        .favorite-btn:hover {
            transform: scale(1.03);
        }

        .product-image {
            width: 100%;
            height: 220px;
            border-radius: 14px;
            background: var(--accent-soft);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-info {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .product-name {
            font-size: 1.05rem;
            font-weight: 600;
        }

        .product-description {
            font-size: 0.9rem;
            color: var(--text-muted);
            min-height: 44px;
        }

        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.75rem;
        }

        .product-price {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .add-to-cart {
            border: 1px solid var(--text-main);
            background: var(--text-main);
            color: #fff;
            border-radius: 999px;
            padding: 0.45rem 1.25rem;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .add-to-cart.is-added {
            background: transparent;
            color: var(--text-main);
        }

        .add-to-cart:hover {
            background: var(--accent-hover);
            color: #fff;
        }

        /* Footer */
        footer {
            padding: 2.5rem 1.5rem;
            background: var(--surface);
            border-top: 1px solid var(--line);
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            align-items: center;
        }

        .footer-links {
            display: flex;
            gap: 1.25rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .footer-text {
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .header-container {
                flex-wrap: wrap;
            }

            .search-bar {
                order: 3;
                width: 100%;
            }
        }

        @media (max-width: 600px) {
            .header-container {
                padding: 0 1rem;
            }

            .hero {
                padding: 2.5rem 1.25rem;
            }

            .products {
                padding: 0 1rem;
            }

            .products-grid {
                grid-template-columns: 1fr;
            }
        }
            </style>
    </head>
<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <div class="header-left">
                <a href="/" class="logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Klavera Logo">
                </a>
            </div>

            <div class="catalog-section">
                <button class="catalog-btn" id="catalogBtn" type="button">
                    <span class="menu-toggle">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                    <span class="catalog-label">Catalog</span>
                </button>
                <div class="catalog-dropdown" id="catalogDropdown">
                    <div class="catalog-grid">
                        <a href="{{ route('home') }}" class="catalog-item {{ $activeCategory ? '' : 'is-active' }}">
                            Все товары
                        </a>
                        @foreach($categories as $category)
                            <a
                                href="{{ route('home', ['category' => $category->slug]) }}"
                                class="catalog-item {{ optional($activeCategory)->id === $category->id ? 'is-active' : '' }}"
                            >
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="search-bar">
                <input type="text" placeholder="Search products..." id="searchInput">
                <button class="search-icon-btn" type="button" id="searchBtn">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </div>

            <div class="header-actions">
                @auth
                    <a href="{{ route('profile') }}" class="profile-icon" title="Profile">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="profile-icon" title="Sign Up">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>New Collection</h1>
            <p>Discover a world of elegance and style. A women's clothing collection created for those who value beauty and comfort.</p>
            <a href="#products" class="hero-btn">Go to Collection</a>
        </div>
    </section>

    <!-- Products -->
    @php
        $sectionTitle = $activeCategory?->name ?? 'Все товары';
    @endphp
    <section class="products" id="products">
        <h2 class="section-title">{{ $sectionTitle }}</h2>
        @if($activeCategory)
            <p class="section-subtitle">
                Показаны товары только из категории «{{ $activeCategory->name }}».
                <a href="{{ route('home') }}">Сбросить фильтр</a>
            </p>
        @endif
        @if($products->count())
            <div class="products-grid">
                @foreach($products as $productItem)
                    @php
                        $cover = $productItem->image ?? optional($productItem->images->first())->path;
                    @endphp
                    <div
                        class="product-card"
                        data-detail-url="{{ route('products.show', $productItem->id) }}"
                        tabindex="0"
                        aria-label="Подробнее о {{ $productItem->name }}"
                    >
                        <button
                            class="favorite-btn"
                            type="button"
                            aria-label="Добавить в избранное"
                            aria-pressed="false"
                            data-product-id="{{ $productItem->id }}"
                        >
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 20.5s-6.2-3.9-8.5-7.2c-1.6-2.3-1.7-5.3 0.2-7.1a4.3 4.3 0 0 1 5.8.3l2.5 2.5 2.5-2.5a4.3 4.3 0 0 1 5.8-.3c1.9 1.8 1.8 4.8 0.2 7.1-2.3 3.3-8.5 7.2-8.5 7.2z"/>
                            </svg>
                        </button>
                        <div class="product-image">
                            @if($cover)
                                <img src="{{ asset('storage/' . $cover) }}" alt="{{ $productItem->name }}">
                            @else
                                <span>📦</span>
                            @endif
                        </div>
                        <div class="product-info">
                            @if($productItem->category)
                                <span class="badge" style="margin-bottom: 0.5rem;">
                                    {{ $productItem->category->name }}
                                </span>
                            @endif
                            <h3 class="product-name">{{ $productItem->name }}</h3>
                            <p class="product-description">{{ \Illuminate\Support\Str::limit($productItem->description, 100) }}</p>
                            <div class="product-footer">
                                <span class="product-price">${{ number_format($productItem->price, 2) }}</span>
                                <button
                                    class="add-to-cart"
                                    type="button"
                                    data-product-id="{{ $productItem->id }}"
                                >
                                    В корзину
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p style="text-align: center; color: var(--text-gray); font-size: 1.1rem;">
                Товары скоро появятся. Загляните позже!
            </p>
        @endif
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-links">
                <a href="#">About Us</a>
                <a href="#">Shipping & Payment</a>
                <a href="#">Returns</a>
                <a href="#">Contact</a>
            </div>
            <p class="footer-text">&copy; {{ date('Y') }} Klavera. All rights reserved.</p>
        </div>
    </footer>

    <script>
        const catalogBtn = document.getElementById('catalogBtn');
        const catalogDropdown = document.getElementById('catalogDropdown');

        if (catalogBtn && catalogDropdown) {
            catalogBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                catalogDropdown.classList.toggle('active');
            });

            document.addEventListener('click', (e) => {
                if (!e.target.closest('.catalog-section')) {
                    catalogDropdown.classList.remove('active');
                }
            });
        }

        const searchInput = document.getElementById('searchInput');
        const searchBtn = document.getElementById('searchBtn');

        function performSearch() {
            if (searchInput) {
                const query = searchInput.value.trim();
                if (query) {
                    // Here you can implement search functionality
                    console.log('Searching for:', query);
                    // window.location.href = '/search?q=' + encodeURIComponent(query);
                }
            }
        }

        if (searchBtn) {
            searchBtn.addEventListener('click', performSearch);
        }

        if (searchInput) {
            searchInput.addEventListener('keydown', (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    performSearch();
                }
            });
        }

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

        document.querySelectorAll('.favorite-btn').forEach((button) => {
            const productId = button.dataset.productId;
            if (favorites.has(productId)) {
                button.classList.add('is-active');
                button.setAttribute('aria-pressed', 'true');
            }

            button.addEventListener('click', (event) => {
                event.stopPropagation();
                if (favorites.has(productId)) {
                    favorites.delete(productId);
                    button.classList.remove('is-active');
                    button.setAttribute('aria-pressed', 'false');
                } else {
                    favorites.add(productId);
                    button.classList.add('is-active');
                    button.setAttribute('aria-pressed', 'true');
                }
                persistSet(favoriteStorageKey, favorites);
            });
        });

        const updateCartButton = (button, isAdded) => {
            if (isAdded) {
                button.classList.add('is-added');
                button.textContent = 'В корзине';
            } else {
                button.classList.remove('is-added');
                button.textContent = 'В корзину';
            }
        };

        const isAuthenticated = @json(auth()->check());
        
        document.querySelectorAll('.add-to-cart').forEach((button) => {
            const productId = button.dataset.productId;
            const isInCart = cartItems.has(productId);
            updateCartButton(button, isInCart);

            button.addEventListener('click', (event) => {
                event.stopPropagation();
                
                // Проверка авторизации
                if (!isAuthenticated) {
                    alert('Чтобы добавить товар в корзину, необходимо авторизоваться');
                    window.location.href = '{{ route("login") }}';
                    return;
                }
                
                if (cartItems.has(productId)) {
                    cartItems.delete(productId);
                    updateCartButton(button, false);
                } else {
                    cartItems.add(productId);
                    updateCartButton(button, true);
                }
                persistSet(cartStorageKey, cartItems);
            });
        });

        document.querySelectorAll('.product-card[data-detail-url]').forEach((card) => {
            card.addEventListener('click', (event) => {
                if (event.target.closest('.favorite-btn') || event.target.closest('.add-to-cart')) {
                    return;
                }
                window.location.href = card.dataset.detailUrl;
            });

            card.addEventListener('keydown', (event) => {
                if (event.key === 'Enter') {
                    card.click();
                }
            });
        });
    </script>
    </body>
</html>
