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
            padding: 0.35rem 0;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            min-height: 48px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-shrink: 0;
        }

        .logo {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }

        .logo img {
            width: 36px;
            height: 36px;
            object-fit: contain;
        }

        .catalog-section {
            position: relative;
            flex-shrink: 0;
            z-index: 1000;
        }

        .catalog-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.9rem;
            border: 1px solid var(--line);
            border-radius: 999px;
            background: transparent;
            cursor: pointer;
            transition: border-color 0.25s ease, color 0.25s ease;
            font-weight: 500;
            font-size: 0.9rem;
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
            flex: 1 1 auto;
            position: relative;
            display: flex;
            align-items: center;
            gap: 0;
            min-width: 0;
        }

        .search-bar input {
            flex: 1 1 auto;
            min-width: 0;
            padding: 0.55rem 4rem 0.55rem 1rem;
            border-radius: 999px;
            border: 1px solid var(--line);
            background: var(--surface);
            font-size: 0.9rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .search-bar input:focus {
            outline: none;
            border-color: var(--text-main);
            box-shadow: 0 0 0 3px rgba(0,0,0,0.05);
        }

        .search-actions {
            position: absolute;
            right: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
            flex-shrink: 0;
        }

        .search-icon-btn {
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
            flex-shrink: 0;
        }

        .search-icon-btn:hover {
            background: var(--accent-hover);
            transform: scale(1.03);
        }

        .search-icon-btn svg {
            width: 16px;
            height: 16px;
        }

        .filter-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid var(--line);
            background: var(--surface);
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: border-color 0.2s ease, background 0.2s ease;
            flex-shrink: 0;
        }

        .filter-btn:hover {
            border-color: var(--text-main);
            background: var(--accent-soft);
        }

        .filter-btn svg {
            width: 16px;
            height: 16px;
        }

        /* Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            padding: 1rem;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal {
            background: var(--surface);
            border-radius: 20px;
            padding: 2rem;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }

        .modal-overlay.active .modal {
            transform: scale(1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 600;
            font-family: 'Playfair Display', serif;
        }

        .modal-close {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid var(--line);
            background: transparent;
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: border-color 0.2s ease, background 0.2s ease;
        }

        .modal-close:hover {
            border-color: var(--text-main);
            background: var(--accent-soft);
        }

        .modal-close svg {
            width: 18px;
            height: 18px;
        }

        .filter-group {
            margin-bottom: 1.5rem;
        }

        .filter-label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .filter-input {
            width: 100%;
            padding: 0.65rem 1rem;
            border-radius: 8px;
            border: 1px solid var(--line);
            background: var(--surface);
            font-size: 0.95rem;
            transition: border-color 0.2s ease;
        }

        .filter-input:focus {
            outline: none;
            border-color: var(--text-main);
        }

        .filter-row {
            display: flex;
            gap: 0.75rem;
            align-items: center;
        }

        .filter-row .filter-input {
            flex: 1;
        }

        .filter-select {
            width: 100%;
            padding: 0.65rem 1rem;
            border-radius: 8px;
            border: 1px solid var(--line);
            background: var(--surface);
            font-size: 0.95rem;
            transition: border-color 0.2s ease;
            cursor: pointer;
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--text-main);
        }

        .modal-actions {
            display: flex;
            gap: 0.75rem;
            justify-content: flex-end;
            margin-top: 2rem;
        }

        .btn-primary {
            padding: 0.75rem 1.5rem;
            border-radius: 999px;
            border: none;
            background: var(--accent);
            color: #fff;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .btn-primary:hover {
            background: var(--accent-hover);
        }

        .btn-secondary {
            padding: 0.75rem 1.5rem;
            border-radius: 999px;
            border: 1px solid var(--line);
            background: transparent;
            color: var(--text-main);
            font-weight: 600;
            cursor: pointer;
            transition: border-color 0.2s ease, background 0.2s ease;
        }

        .btn-secondary:hover {
            border-color: var(--text-main);
            background: var(--accent-soft);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
        }

        .profile-icon,
        .basket-icon,
        .favorites-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1px solid var(--line);
            background: var(--surface);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--text-main);
            text-decoration: none;
            transition: border-color 0.2s ease;
            position: relative;
        }

        .profile-icon:hover,
        .basket-icon:hover,
        .favorites-icon:hover {
            border-color: var(--text-main);
        }

        .favorites-icon svg {
            stroke: var(--favorite);
        }

        .basket-icon .basket-count {
            position: absolute;
            top: -4px;
            right: -4px;
            background: var(--accent);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 600;
            border: 2px solid var(--surface);
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
            width: 280px;
            box-shadow: 0 12px 40px rgba(0,0,0,0.08);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-6px);
            transition: opacity 0.2s ease, transform 0.2s ease;
            z-index: 1000;
        }

        .catalog-dropdown.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .catalog-grid {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .catalog-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: inherit;
            text-decoration: none;
            padding: 0.6rem 0.85rem;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .catalog-item:hover {
            background: var(--accent-soft);
            transform: translateX(2px);
        }

        .catalog-item.is-active {
            background: var(--text-main);
            color: var(--surface);
            font-weight: 600;
        }

        .catalog-item.is-active:hover {
            transform: translateX(0);
        }

        .category-arrow {
            margin-left: 0.5rem;
            transition: transform 0.2s ease;
            flex-shrink: 0;
            width: 10px;
            height: 10px;
        }

        .catalog-category-item {
            position: relative;
        }

        .catalog-category-item.has-open .category-arrow {
            transform: rotate(90deg);
        }

        .catalog-item {
            position: relative;
        }

        .catalog-item-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .catalog-item-wrapper .catalog-item {
            flex: 1;
        }

        .category-toggle {
            background: none;
            border: none;
            padding: 0.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: inherit;
            transition: transform 0.2s ease;
        }

        .category-toggle:hover {
            background: var(--accent-soft);
            border-radius: 6px;
        }

        .catalog-category-item.has-open .category-toggle .category-arrow {
            transform: rotate(90deg);
        }

        .catalog-item.has-children {
            cursor: pointer;
        }

        .subcategories-dropdown {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, opacity 0.2s ease;
            opacity: 0;
            padding: 0;
            margin-top: 0.5rem;
            margin-left: 1rem;
            display: none !important;
        }

        /* Show only DIRECT subcategories of parent category */
        .catalog-category-item.has-open > .subcategories-dropdown {
            max-height: 500px;
            opacity: 1;
            padding: 0.5rem 0;
            display: block !important;
        }

        /* Nested categories in subcategories */
        .subcategories-dropdown .catalog-category-item {
            margin-bottom: 0.25rem;
        }

        .subcategories-dropdown .catalog-item {
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
        }

        /* Nested subcategories should also be hidden by default */
        /* All nested subcategories are hidden by default */
        .subcategories-dropdown .subcategories-dropdown {
            margin-left: 1.5rem;
            max-height: 0;
            opacity: 0;
            display: none !important;
        }

        /* Show nested subcategories only if their direct parent has has-open */
        .subcategories-dropdown .catalog-category-item.has-open > .subcategories-dropdown {
            margin-left: 1.5rem;
            max-height: 500px;
            opacity: 1;
            display: block !important;
        }

        .catalog-dropdown {
            overflow: visible;
        }


        .subcategory-item {
            display: block;
            color: inherit;
            text-decoration: none;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s ease;
            margin-bottom: 0.25rem;
        }

        .subcategory-item:hover {
            background: var(--accent-soft);
            transform: translateX(2px);
        }

        .subcategory-item.is-active {
            background: var(--text-main);
            color: var(--surface);
            font-weight: 600;
        }

        .subcategory-item.is-active:hover {
            transform: translateX(0);
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

        /* Currency rates widget */
        .rates-widget {
            max-width: 1200px;
            margin: 1.25rem auto 2.25rem;
            padding: 0 1.5rem;
        }

        .rates-card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 1.25rem 1.25rem;
            box-shadow: 0 10px 24px rgba(0,0,0,0.04);
        }

        .rates-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .rates-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.35rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .rates-subtitle {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-top: 0.25rem;
        }

        .rates-updated {
            color: var(--text-muted);
            font-size: 0.9rem;
            white-space: nowrap;
        }

        .rates-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.75rem;
        }

        .rate-item {
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 0.85rem 0.9rem;
            background: #fff;
        }

        .rate-code {
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .rate-value {
            margin-top: 0.25rem;
            font-size: 1.05rem;
            font-weight: 600;
        }

        .rate-label {
            margin-top: 0.15rem;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .rates-empty {
            margin-top: 0.9rem;
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        @media (max-width: 640px) {
            .rates-top {
                flex-direction: column;
                align-items: flex-start;
            }
            .rates-grid {
                grid-template-columns: 1fr;
            }
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

        /* Pagination */
        .pagination-wrapper {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
        }

        .pagination-wrapper .pagination {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            list-style: none;
            padding: 0;
        }

        .pagination-wrapper .pagination li {
            display: inline-block;
        }

        .pagination-wrapper .pagination a,
        .pagination-wrapper .pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            text-decoration: none;
            color: var(--text-main);
            border: 1px solid var(--line);
            background: var(--surface);
            transition: all 0.2s ease;
            min-width: 40px;
        }

        .pagination-wrapper .pagination a:hover {
            background: var(--accent-soft);
            border-color: var(--text-main);
        }

        .pagination-wrapper .pagination .active span {
            background: var(--text-main);
            color: var(--surface);
            border-color: var(--text-main);
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
                    @foreach($categories as $category)
                        @include('partials.catalog-category', ['category' => $category, 'categories' => $allCategories ?? $categories, 'activeCategory' => $activeCategory])
                    @endforeach
                </div>
            </div>
        </div>

        <div class="search-bar">
            <input type="text" placeholder="Search products..." id="searchInput" value="{{ request('query') ?? request('search') }}">
            <div class="search-actions">
                <button class="filter-btn" type="button" id="filterBtn" title="Filters">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                </button>
                <button class="search-icon-btn" type="button" id="searchBtn">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="header-actions">
            @auth
                @php
                    $basket = \App\Models\Basket::where('user_id', auth()->id())->first();
                    $basketCount = $basket ? $basket->items()->count() : 0;
                @endphp
                <a href="{{ route('basket.index') }}" class="basket-icon" title="Basket">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    @if($basketCount > 0)
                        <span class="basket-count">{{ $basketCount }}</span>
                    @endif
                </a>
                <a href="{{ route('favorites.index') }}" class="favorites-icon" title="Favorites">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </a>
                <a href="{{ route('profile') }}" class="profile-icon" title="Profile">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </a>
            @else
                <a href="{{ route('registerForm') }}" class="profile-icon" title="Sign Up">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </a>
            @endauth
        </div>
    </div>
</header>

@include('partials.currency-rates-widget', [
    'currencyRates' => $currencyRates ?? collect(),
    'currencyRatesUpdatedAt' => $currencyRatesUpdatedAt ?? null,
])

<!-- Products -->
@php
    $sectionTitle = $activeCategory?->name ?? 'Product Catalog';
@endphp
<section class="products" id="products">
    <h2 class="section-title">{{ $sectionTitle }}</h2>
    @if($activeCategory)
        <p class="section-subtitle">
            Showing products only from category «{{ $activeCategory->name }}».
            <a href="{{ route('home') }}">Reset filter</a>
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
                    aria-label="Learn more about {{ $productItem->name }}"
                >
                    <button
                        class="favorite-btn"
                        type="button"
                        aria-label="Add to favorites"
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
                                Add to cart
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if(method_exists($products, 'links'))
            <div class="pagination-wrapper" style="margin-top: 2rem; display: flex; justify-content: center;">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @endif
    @else
        <p style="text-align: center; color: var(--text-gray); font-size: 1.1rem;">
            Products will appear soon. Check back later!
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
    // Wait for DOM to load
    document.addEventListener('DOMContentLoaded', function() {
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

        // Ensure all subcategories are hidden on load
        document.addEventListener('DOMContentLoaded', () => {
            // Remove has-open class from all categories on load (if it was added automatically)
            document.querySelectorAll('.catalog-category-item').forEach(item => {
                // Don't remove if category is active - just ensure CSS hides subcategories by default
            });
        });

        // Handle clicks on category toggle buttons (for categories with subcategories)
        document.addEventListener('click', (e) => {
            // Check if click was on a category toggle button
            const toggleButton = e.target.closest('.category-toggle');
            if (toggleButton) {
                e.preventDefault();
                e.stopPropagation();
                const categoryItem = toggleButton.closest('.catalog-category-item');
                if (categoryItem) {
                    categoryItem.classList.toggle('has-open');
                }
                return;
            }

            // Handle clicks on category links with subcategories (for nested categories)
            const clickedLink = e.target.closest('.catalog-item.has-children');
            if (!clickedLink) return;

            // Find parent category element
            const categoryItem = clickedLink.closest('.catalog-category-item');
            if (!categoryItem) return;

            // Check that click was NOT on a subcategory inside an already expanded category
            const parentDropdown = clickedLink.closest('.subcategories-dropdown');
            
            if (parentDropdown) {
                // If this is a subcategory that itself has subcategories, handle it
                if (categoryItem.querySelector('.subcategories-dropdown')) {
                    e.preventDefault();
                    e.stopPropagation();
                    categoryItem.classList.toggle('has-open');
                }
                return;
            }
        });

        const searchInput = document.getElementById('searchInput');
        const searchBtn = document.getElementById('searchBtn');

        function performSearch() {
            if (searchInput) {
                const query = searchInput.value.trim();
                if (query) {
                    const url = new URL(window.location.href);
                    url.searchParams.set('query', query);
                    url.searchParams.delete('search'); // Remove old parameter for compatibility
                    window.location.href = url.toString();
                } else {
                    const url = new URL(window.location.href);
                    url.searchParams.delete('query');
                    url.searchParams.delete('search');
                    window.location.href = url.toString();
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

        const isAuthenticated = @json(auth()->check());

        // Check favorites state on page load
        if (isAuthenticated) {
            fetch('{{ route("favorites.index") }}')
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    document.querySelectorAll('.favorite-btn').forEach((button) => {
                        const productId = button.dataset.productId;
                        const productLink = doc.querySelector(`a[href*="/products/${productId}"]`);
                        if (productLink && productLink.closest('.card')) {
                            button.classList.add('is-active');
                            button.setAttribute('aria-pressed', 'true');
                        }
                    });
                })
                .catch(() => {});
        }

        document.querySelectorAll('.favorite-btn').forEach((button) => {
            const productId = button.dataset.productId;

            button.addEventListener('click', (event) => {
                event.stopPropagation();

                // Check authentication
                if (!isAuthenticated) {
                    alert('To add product to favorites, please login');
                    window.location.href = '{{ route("loginForm") }}';
                    return;
                }

                const isActive = button.classList.contains('is-active');
                button.disabled = true;

                if (isActive) {
                    // Remove from favorites
                    const formData = new FormData();
                    formData.append('product_id', productId);
                    formData.append('_token', '{{ csrf_token() }}');

                    fetch('{{ route("favorites.removeByProduct") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                button.classList.remove('is-active');
                                button.setAttribute('aria-pressed', 'false');
                            }
                            button.disabled = false;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            button.disabled = false;
                        });
                } else {
                    // Add to favorites
                    const formData = new FormData();
                    formData.append('product_id', productId);
                    formData.append('_token', '{{ csrf_token() }}');

                    fetch('{{ route("favorites.store") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                button.classList.add('is-active');
                                button.setAttribute('aria-pressed', 'true');
                            }
                            button.disabled = false;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            button.disabled = false;
                        });
                }
            });
        });

        const updateCartButton = (button, isAdded) => {
            if (isAdded) {
                button.classList.add('is-added');
                button.textContent = 'In cart';
            } else {
                button.classList.remove('is-added');
                button.textContent = 'Add to cart';
            }
        };

        document.querySelectorAll('.add-to-cart').forEach((button) => {
            const productId = button.dataset.productId;

            // Check cart state on page load
            if (isAuthenticated) {
                fetch('{{ route("basket.index") }}')
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const productLink = doc.querySelector(`a[href*="/products/${productId}"]`);
                        if (productLink && productLink.closest('.card')) {
                            updateCartButton(button, true);
                        }
                    })
                    .catch(() => {});
            }

            button.addEventListener('click', (event) => {
                event.stopPropagation();

                // Check authentication
                if (!isAuthenticated) {
                    alert('Please log in to add products to cart');
                    window.location.href = '{{ route("loginForm") }}';
                    return;
                }

                button.disabled = true;

                // Add product to cart
                const formData = new FormData();
                formData.append('product_id', productId);
                formData.append('quantity', 1);
                formData.append('_token', '{{ csrf_token() }}');

                fetch('{{ route("basket.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                })
                    .then(response => {
                        if (response.redirected) {
                            window.location.href = response.url;
                        } else {
                            return response.json().catch(() => ({}));
                        }
                    })
                    .then(data => {
                        updateCartButton(button, true);
                        // Reload page to sync with server
                        setTimeout(() => {
                            window.location.reload();
                        }, 500);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        button.disabled = false;
                        alert('An error occurred while adding product to cart');
                    });
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

        // Filter Modal
        const filterBtn = document.getElementById('filterBtn');
        const filterModalOverlay = document.getElementById('filterModalOverlay');
        const filterModalClose = document.getElementById('filterModalClose');
        const filterForm = document.getElementById('filterForm');

        if (filterBtn && filterModalOverlay) {
            filterBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                filterModalOverlay.classList.add('active');
            });
        }

        if (filterModalClose && filterModalOverlay) {
            filterModalClose.addEventListener('click', () => {
                filterModalOverlay.classList.remove('active');
            });
        }

        if (filterModalOverlay) {
            filterModalOverlay.addEventListener('click', (e) => {
                if (e.target === filterModalOverlay) {
                    filterModalOverlay.classList.remove('active');
                }
            });
        }

        if (filterForm) {
            filterForm.addEventListener('submit', (e) => {
                e.preventDefault();

                const formData = new FormData(filterForm);
                const params = new URLSearchParams();

                // Add search parameters
                const query = document.getElementById('searchInput')?.value.trim();
                if (query) {
                    params.set('query', query);
                }

                // Add filters
                const categoryId = formData.get('category_id');
                if (categoryId) {
                    params.set('category_id', categoryId);
                }

                const minPrice = formData.get('min_price');
                if (minPrice) {
                    params.set('min_price', minPrice);
                }

                const maxPrice = formData.get('max_price');
                if (maxPrice) {
                    params.set('max_price', maxPrice);
                }

                const sortBy = formData.get('sort_by');
                if (sortBy) {
                    params.set('sort_by', sortBy);
                }

                const sortOrder = formData.get('sort_order');
                if (sortOrder) {
                    params.set('sort_order', sortOrder);
                }

                // Redirect to page with filters
                window.location.href = '{{ route("home") }}?' + params.toString();
            });
        }

        // Populate filter form with current values from URL
        const urlParams = new URLSearchParams(window.location.search);
        const filterCategoryId = document.getElementById('filterCategoryId');
        const filterMinPrice = document.getElementById('filterMinPrice');
        const filterMaxPrice = document.getElementById('filterMaxPrice');
        const filterSortBy = document.getElementById('filterSortBy');
        const filterSortOrder = document.getElementById('filterSortOrder');

        if (filterCategoryId && urlParams.has('category_id')) {
            filterCategoryId.value = urlParams.get('category_id');
        }
        if (filterMinPrice && urlParams.has('min_price')) {
            filterMinPrice.value = urlParams.get('min_price');
        }
        if (filterMaxPrice && urlParams.has('max_price')) {
            filterMaxPrice.value = urlParams.get('max_price');
        }
        if (filterSortBy && urlParams.has('sort_by')) {
            filterSortBy.value = urlParams.get('sort_by');
        }
        if (filterSortOrder && urlParams.has('sort_order')) {
            filterSortOrder.value = urlParams.get('sort_order');
        }
    });
</script>

<!-- Filter Modal -->
<div class="modal-overlay" id="filterModalOverlay">
    <div class="modal" id="filterModal">
        <div class="modal-header">
            <h2 class="modal-title">Filters</h2>
            <button class="modal-close" id="filterModalClose" type="button" aria-label="Close">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="filterForm">
            <div class="filter-group">
                <label class="filter-label" for="filterCategoryId">Category</label>
                <select class="filter-select" id="filterCategoryId" name="category_id">
                    @php
                        $allCats = $allCategories ?? $categories->flatten();
                        $selectedCategoryId = request('category_id');
                    @endphp
                    @include('partials.category-options', [
                        'categories' => $allCats,
                        'parentId' => null,
                        'level' => 0,
                        'selectedId' => $selectedCategoryId,
                    ])
                </select>
            </div>

            <div class="filter-group">
                <label class="filter-label">Price</label>
                <div class="filter-row">
                    <input
                        type="number"
                        class="filter-input"
                        id="filterMinPrice"
                        name="min_price"
                        placeholder="From"
                        min="0"
                        step="0.01"
                        value="{{ request('min_price') }}"
                    >
                    <span>-</span>
                    <input
                        type="number"
                        class="filter-input"
                        id="filterMaxPrice"
                        name="max_price"
                        placeholder="To"
                        min="0"
                        step="0.01"
                        value="{{ request('max_price') }}"
                    >
                </div>
            </div>

            <div class="filter-group">
                <label class="filter-label" for="filterSortBy">Sort by</label>
                <select class="filter-select" id="filterSortBy" name="sort_by">
                    <option value="name" {{ request('sort_by', 'name') == 'name' ? 'selected' : '' }}>By name</option>
                    <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>By price</option>
                </select>
            </div>

            <div class="filter-group">
                <label class="filter-label" for="filterSortOrder">Sort order</label>
                <select class="filter-select" id="filterSortOrder" name="sort_order">
                    <option value="desc" {{ request('sort_order', 'desc') == 'desc' ? 'selected' : '' }}>Descending</option>
                    <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                </select>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-secondary" onclick="document.getElementById('filterModalOverlay').classList.remove('active')">
                    Cancel
                </button>
                <button type="submit" class="btn-primary">
                    Apply filters
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
