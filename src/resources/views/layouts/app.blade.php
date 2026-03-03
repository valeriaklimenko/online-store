<!DOCTYPE html>
<html lang="en">
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
                <a href="{{ url('/') }}" class="site-logo" title="Go to Home">
                    <img src="{{ asset('images/logo.png') }}" alt="Klavera Logo">
                    <span>Klavera</span>
                </a>
                <div class="site-actions">
                    @auth
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="pill-btn pill-btn--solid">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('loginForm') }}" class="pill-btn">Login</a>
                        <a href="{{ route('registerForm') }}" class="pill-btn pill-btn--solid">Register</a>
                    @endauth
                </div>
            </div>
        </header>

        <main class="page-shell">
            @yield('content')
        </main>

        <footer>
            &copy; {{ date('Y') }} Klavera. All rights reserved.
        </footer>

        @stack('scripts')
    </body>
</html>

