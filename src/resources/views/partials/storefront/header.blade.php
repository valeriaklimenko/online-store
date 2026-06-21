@php
    use App\Enums\RoleSystem\Roles;

    $basketCount = 0;
    $storefrontUser = auth()->user();
    $storefrontProfileRoute = route('profile');

    if (auth()->check()) {
        $basket = \App\Models\Basket::where('user_id', auth()->id())->first();
        $basketCount = $basket ? $basket->items()->sum('quantity') : 0;

        if ($storefrontUser?->hasRole(Roles::ADMIN->value)) {
            $storefrontProfileRoute = route('admin.profile');
        } elseif ($storefrontUser?->hasRole(Roles::MANAGER->value)) {
            $storefrontProfileRoute = route('manager.profile');
        }
    }
@endphp

<header class="klavera-header" id="klaveraHeader">
    <div class="klavera-shell klavera-header__inner">
        <nav class="klavera-nav klavera-nav--left" aria-label="Main">
            <a href="{{ route('home', ['new_collection' => 1]) }}#products"
               class="klavera-nav__link {{ ($isNewCollectionFilter ?? false) ? 'is-active' : '' }}">New</a>
            <div class="klavera-nav__item">
                <button type="button" class="klavera-nav__link" aria-haspopup="true" aria-expanded="false">Shop</button>
                @include('partials.storefront.category-nav', [
                    'categories' => $categories ?? collect(),
                    'activeCategory' => $activeCategory ?? null,
                ])
            </div>
            <a href="{{ route('home') }}#products" class="klavera-nav__link">Discover</a>
        </nav>

        <a href="{{ route('home') }}" class="klavera-logo" aria-label="Klavera home">Klavera</a>

        <div class="klavera-nav klavera-nav--right">
            <button type="button" class="klavera-icon-btn" id="openSearchPanel" aria-label="Search">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
            <button type="button" class="klavera-icon-btn" id="openAccountPanel" aria-label="Account">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </button>
            <button type="button" class="klavera-icon-btn" id="openCartPanel" aria-label="Basket">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4H6zM3 6h18M16 10a4 4 0 01-8 0"/>
                </svg>
                <span class="klavera-cart-count" id="headerCartCount"
                      @if($basketCount === 0) hidden @endif>{{ $basketCount }}</span>
            </button>
        </div>
    </div>
</header>
