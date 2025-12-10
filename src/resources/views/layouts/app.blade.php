<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Klavera')</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/minimal.css') }}">
        @stack('styles')
    </head>
    <body>
        <header class="site-header">
            <div class="site-shell">
                <a href="{{ url('/') }}" class="site-logo" title="На главную">
                    <img src="{{ asset('images/logo.png') }}" alt="Klavera Logo">
                    <span>Klavera</span>
                </a>
                <nav class="site-nav">
                    <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'is-active' : '' }}">Главная</a>
                    <a href="{{ url('/#products') }}">Каталог</a>
                </nav>
                <div class="site-actions">
                    @auth
                        <a href="{{ route('profile') }}" class="pill-btn">Профиль</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="pill-btn pill-btn--solid">Выйти</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="pill-btn">Войти</a>
                        <a href="{{ route('register') }}" class="pill-btn pill-btn--solid">Регистрация</a>
                    @endauth
                </div>
            </div>
        </header>

        <main class="page-shell">
            @yield('content')
        </main>

        <footer>
            &copy; {{ date('Y') }} Klavera. Все права защищены.
        </footer>

        @stack('scripts')
    </body>
</html>

