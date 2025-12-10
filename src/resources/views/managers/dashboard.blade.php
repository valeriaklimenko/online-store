@extends('layouts.app')

@section('title', 'Панель менеджера — Klavera')

@section('content')
    <div class="profile-layout">
        <div class="profile-info-card">
            <div class="profile-info-header">
                <h1>
                    {{ auth()->user()}}
                </h1>
                <p>{{ auth()->user()}}</p>
                <span class="admin-badge">Manager</span>
            </div>
        </div>

        <div class="profile-sidebar">
            <h2>Меню</h2>
            <ul class="profile-menu">
                <li class="profile-menu-item">
                    <a href="{{ route('manager.dashboard') }}" class="profile-menu-link">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Главная</span>
                    </a>
                </li>
                <li class="profile-menu-item">
                    <a href="{{ route('products.index') }}" class="profile-menu-link">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <span>Управление товарами</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div style="margin-bottom: 2rem; margin-top: 2rem;">
        <h1 style="font-family: 'Playfair Display', serif; font-size: 2rem; color: #6b212c; margin-bottom: 0.5rem;">
            Панель менеджера
        </h1>
        <p style="color: var(--text-gray); font-size: 1rem;">
            Добро пожаловать, {{ auth()->user()}}! Здесь вы можете управлять товарами магазина.
        </p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 2rem;">
        <div class="info-section" style="text-align: center; padding: 2rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">📦</div>
            <h3 style="font-size: 1.5rem; color: #6b212c; margin-bottom: 1rem;">Управление товарами</h3>
            <p style="color: var(--text-gray); margin-bottom: 1.5rem;">
                Добавляйте, редактируйте и удаляйте товары в каталоге
            </p>
            <a href="{{ route('products.index') }}" class="btn" style="background: #6b212c; color: white; padding: 0.75rem 1.5rem; border-radius: 12px; text-decoration: none; display: inline-block; font-weight: 600;">
                Перейти к товарам
            </a>
        </div>

        <div class="info-section" style="text-align: center; padding: 2rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">📊</div>
            <h3 style="font-size: 1.5rem; color: #6b212c; margin-bottom: 1rem;">Статистика</h3>
            <p style="color: var(--text-gray); margin-bottom: 1.5rem;">
                Просматривайте статистику продаж и заказов
            </p>
            <a href="#" class="btn" style="background: #8ea1ae; color: white; padding: 0.75rem 1.5rem; border-radius: 12px; text-decoration: none; display: inline-block; font-weight: 600; opacity: 0.7; cursor: not-allowed;">
                Скоро
            </a>
        </div>

        <div class="info-section" style="text-align: center; padding: 2rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">📋</div>
            <h3 style="font-size: 1.5rem; color: #6b212c; margin-bottom: 1rem;">Заказы</h3>
            <p style="color: var(--text-gray); margin-bottom: 1.5rem;">
                Управляйте заказами клиентов
            </p>
            <a href="#" class="btn" style="background: #8ea1ae; color: white; padding: 0.75rem 1.5rem; border-radius: 12px; text-decoration: none; display: inline-block; font-weight: 600; opacity: 0.7; cursor: not-allowed;">
                Скоро
            </a>
        </div>
    </div>

    <div class="info-section">
        <h2 style="font-family: 'Playfair Display', serif; font-size: 1.5rem; color: #6b212c; margin-bottom: 1.5rem;">
            Быстрые действия
        </h2>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="{{ route('products.create') }}" style="background: #6b212c; color: white; padding: 0.75rem 1.5rem; border-radius: 12px; text-decoration: none; font-weight: 600;">
                ➕ Добавить товар
            </a>
            <a href="{{ route('products.index') }}" style="background: #8ea1ae; color: white; padding: 0.75rem 1.5rem; border-radius: 12px; text-decoration: none; font-weight: 600;">
                📦 Все товары
            </a>
        </div>
    </div>
@endsection

