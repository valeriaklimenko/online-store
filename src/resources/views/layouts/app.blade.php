<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Klavera')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Jost:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/klavera.css') }}">
    <link rel="stylesheet" href="{{ asset('css/klavera-app.css') }}">
    @stack('styles')
</head>
<body class="klavera-app">
@include('partials.app.header')

<main class="klavera-app-main">
    @yield('content')
</main>

<footer class="klavera-app-footer">
    &copy; {{ date('Y') }} Klavera. All rights reserved.
</footer>

@stack('scripts')
</body>
</html>
