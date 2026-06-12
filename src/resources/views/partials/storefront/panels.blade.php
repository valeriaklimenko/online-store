@php
    $panelBasketCount = 0;
    if (auth()->check()) {
        $panelBasket = \App\Models\Basket::where('user_id', auth()->id())->first();
        $panelBasketCount = $panelBasket ? $panelBasket->items()->count() : 0;
    }
@endphp

<div class="klavera-panel klavera-panel--search" id="searchPanel" aria-hidden="true">
    <div class="klavera-panel__backdrop" data-close-panel></div>
    <div class="klavera-panel__sheet">
        <div class="klavera-search-bar">
            <button type="button" class="klavera-icon-btn" data-close-panel aria-label="Back">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <input type="search" id="panelSearchInput" placeholder="Search" value="{{ request('query') }}" autocomplete="off">
            <button type="button" class="klavera-panel__close" data-close-panel aria-label="Close">&times;</button>
        </div>
        <div class="klavera-panel__body">
            <div class="klavera-search-trending">
                <h2>Trending searches</h2>
                <ul>
                    <li><a href="{{ route('home', ['new_collection' => 1]) }}#products">New collection</a></li>
                    @foreach($products->take(4) as $trend)
                        <li><a href="{{ route('products.show', $trend->id) }}">{{ $trend->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="klavera-panel" id="accountPanel" aria-hidden="true">
    <div class="klavera-panel__backdrop" data-close-panel></div>
    <div class="klavera-panel__sheet">
        <div class="klavera-panel__header">
            <span class="klavera-logo" style="font-size: 1rem; letter-spacing: 0.25em;">Klavera</span>
            <button type="button" class="klavera-panel__close" data-close-panel aria-label="Close">&times;</button>
        </div>
        <div class="klavera-panel__body">
            <h2 class="klavera-account__heading">Sign in to your account</h2>
            <p class="klavera-account__sub">Get access to your orders, favorites, and more.</p>
            @auth
                <a href="{{ route('profile') }}" class="klavera-btn">My profile</a>
                <a href="{{ route('orders.index') }}" class="klavera-btn klavera-btn--outline">My orders</a>
            @else
                <a href="{{ route('loginForm') }}" class="klavera-btn">Sign in or sign up</a>
                <a href="{{ route('registerForm') }}" class="klavera-btn klavera-btn--outline">Create account</a>
            @endauth
        </div>
    </div>
</div>

<div class="klavera-panel" id="cartPanel" aria-hidden="true">
    <div class="klavera-panel__backdrop" data-close-panel></div>
    <div class="klavera-panel__sheet">
        <div class="klavera-panel__header">
            <h2 class="klavera-panel__title">Your basket</h2>
            <button type="button" class="klavera-panel__close" data-close-panel aria-label="Close">&times;</button>
        </div>
        <div class="klavera-panel__body">
            @if($panelBasketCount > 0)
                <p style="margin-bottom: 1.5rem;">You have {{ $panelBasketCount }} item(s) in your basket.</p>
                <a href="{{ route('basket.index') }}" class="klavera-btn">View basket</a>
            @else
                <div class="klavera-cart-empty">
                    <p>Your basket is empty</p>
                    <a href="{{ route('home') }}#products" class="klavera-btn klavera-btn--outline" data-close-panel>Continue shopping</a>
                </div>
            @endif
        </div>
    </div>
</div>
