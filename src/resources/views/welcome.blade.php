<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klavera — Women's Fashion</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Jost:wght@300;400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/klavera.css') }}">
</head>
<body class="klavera-body">
@include('partials.storefront.header')

@include('partials.storefront.hero')

<section class="klavera-products" id="products">
    <div class="klavera-shell">
        <div class="klavera-products__head">
            <h2 class="klavera-products__title">
                @if($isNewCollectionFilter)
                    New Collection
                @elseif($activeCategory)
                    {{ $activeCategory->name }}
                @else
                    Our Collection
                @endif
            </h2>
            @if($isNewCollectionFilter || $activeCategory || request('query'))
                <a href="{{ route('home') }}#products" class="klavera-products__reset">View all</a>
            @endif
        </div>

        @if($products->count())
            <div class="klavera-grid">
                @foreach($products as $productItem)
                    @include('partials.storefront.product-card', ['productItem' => $productItem])
                @endforeach
            </div>

            @if(method_exists($products, 'links'))
                <div class="klavera-pagination">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <p class="klavera-empty">
                @if($isNewCollectionFilter)
                    No products in the new collection yet.
                @else
                    Products will appear soon.
                @endif
            </p>
        @endif
    </div>
</section>

@include('partials.storefront.footer')
@include('partials.storefront.panels')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const header = document.getElementById('klaveraHeader');
        const panels = {
            search: document.getElementById('searchPanel'),
            account: document.getElementById('accountPanel'),
            cart: document.getElementById('cartPanel'),
        };

        const openPanel = (panel) => {
            Object.values(panels).forEach((p) => p?.classList.remove('is-open'));
            panel?.classList.add('is-open');
            document.body.style.overflow = 'hidden';
        };

        const closePanels = () => {
            Object.values(panels).forEach((p) => p?.classList.remove('is-open'));
            document.body.style.overflow = '';
        };

        document.getElementById('openSearchPanel')?.addEventListener('click', () => openPanel(panels.search));
        document.getElementById('openAccountPanel')?.addEventListener('click', () => {
            @auth
                window.location.href = '{{ $storefrontProfileRoute ?? route('profile') }}';
            @else
            openPanel(panels.account);
            @endauth
        });

        document.querySelectorAll('[data-category-toggle]').forEach((toggle) => {
            toggle.addEventListener('click', (event) => {
                event.preventDefault();
                event.stopPropagation();

                const item = toggle.closest('.klavera-mega__item');
                const isOpen = item?.classList.toggle('is-open') ?? false;
                toggle.setAttribute('aria-expanded', isOpen.toString());
            });
        });
        document.getElementById('openCartPanel')?.addEventListener('click', () => {
            @auth
                window.location.href = '{{ route('basket.index') }}';
            @else
            openPanel(panels.cart);
            @endauth
        });

        document.querySelectorAll('[data-close-panel]').forEach((el) => {
            el.addEventListener('click', closePanels);
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closePanels();
        });

        const searchInput = document.getElementById('panelSearchInput');
        const runSearch = () => {
            const query = searchInput?.value.trim();
            const url = new URL('{{ route('home') }}', window.location.origin);
            if (query) url.searchParams.set('query', query);
            url.hash = 'products';
            window.location.href = url.toString();
        };

        searchInput?.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                runSearch();
            }
        });

        window.addEventListener('scroll', () => {
            if (!header) return;
            header.classList.toggle('is-scrolled', window.scrollY > 10);
        }, {passive: true});

        const isAuthenticated = @json(auth()->check());

        document.querySelectorAll('.klavera-card').forEach((card) => {
            card.addEventListener('click', (e) => {
                if (e.target.closest('.klavera-card__fav')) return;
                window.location.href = card.dataset.detailUrl;
            });
            card.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') card.click();
            });
        });

        if (isAuthenticated) {
            fetch('{{ route('favorites.index') }}')
                .then((r) => r.text())
                .then((html) => {
                    const doc = new DOMParser().parseFromString(html, 'text/html');
                    document.querySelectorAll('.klavera-card__fav').forEach((btn) => {
                        const id = btn.dataset.productId;
                        if (doc.querySelector(`a[href*="/products/${id}"]`)) {
                            btn.classList.add('is-active');
                            btn.setAttribute('aria-pressed', 'true');
                        }
                    });
                })
                .catch(() => {
                });
        }

        document.querySelectorAll('.klavera-card__fav').forEach((button) => {
            button.addEventListener('click', (e) => {
                e.stopPropagation();
                if (!isAuthenticated) {
                    window.location.href = '{{ route('loginForm') }}';
                    return;
                }

                const productId = button.dataset.productId;
                const isActive = button.classList.contains('is-active');
                const formData = new FormData();
                formData.append('product_id', productId);
                formData.append('_token', '{{ csrf_token() }}');

                const url = isActive
                    ? '{{ route('favorites.removeByProduct') }}'
                    : '{{ route('favorites.store') }}';

                fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json'},
                })
                    .then((r) => r.json())
                    .then((data) => {
                        if (data.success) {
                            button.classList.toggle('is-active', !isActive);
                            button.setAttribute('aria-pressed', (!isActive).toString());
                        }
                    })
                    .catch(() => {
                    });
            });
        });
    });
</script>
</body>
</html>
