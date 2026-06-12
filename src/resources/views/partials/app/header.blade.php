@php
    use App\Enums\RoleSystem\Roles;
    $user = auth()->user();
    $isAdmin = $user?->hasRole(Roles::ADMIN->value);
    $isManager = $user?->hasRole(Roles::MANAGER->value);
    $profileRoute = $isAdmin
        ? route('admin.profile')
        : ($isManager ? route('manager.profile') : route('profile'));
@endphp
<header class="klavera-app-header">
    <div class="klavera-shell klavera-app-header__inner">
        <a href="{{ route('home') }}" class="klavera-app-logo">Klavera</a>

        <nav class="klavera-app-nav" aria-label="App navigation">
            <a href="{{ route('home') }}">Shop</a>
            @auth
                <a href="{{ $profileRoute }}">Profile</a>
                <a href="{{ route('basket.index') }}">Basket</a>
                <a href="{{ route('favorites.index') }}">Favorites</a>
                <a href="{{ route('orders.index') }}">Orders</a>
                @if($isAdmin || $isManager)
                    <a href="{{ route('products.index') }}">Products</a>
                    <a href="{{ route('manage.orders.index') }}">Manage orders</a>
                @endif
                @if($isAdmin)
                    <a href="{{ route('categories.index') }}">Categories</a>
                    <a href="{{ route('managers.index') }}">Managers</a>
                    <a href="{{ route('admin.banner.edit') }}">Banner</a>
                @endif
                @if($isManager)
                    <a href="{{ route('manager.dashboard') }}">Dashboard</a>
                @endif
            @else
                <a href="{{ route('loginForm') }}">Sign in</a>
                <a href="{{ route('registerForm') }}">Register</a>
            @endauth
        </nav>

        <div class="klavera-app-actions">
            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-ghost btn-small">Log out</button>
                </form>
            @endif
        </div>
    </div>
</header>
