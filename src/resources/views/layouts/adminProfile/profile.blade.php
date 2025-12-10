@extends('layouts.app')

@section('title', 'Профиль — ' . $user->name)

@section('content')
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <section class="profile-grid">
        <article class="card profile-card">
            <p class="overline">Команда Klavera</p>
            <h1>{{ $user->name }}</h1>
            <p style="color: var(--text-muted); margin-bottom: 0.75rem;">{{ $user->email }}</p>
            <span class="badge">Администратор</span>
            <div style="margin-top: 1.5rem; display: flex; gap: 0.5rem;">
                <button type="button" class="pill-btn" onclick="toggleSettingsModal()">Настройки</button>
                <a href="{{ route('changePassword') }}" class="pill-btn">Пароль</a>
            </div>
        </article>

        <article class="card profile-menu-card">
            <h2>Панель управления</h2>
            <ul class="profile-menu">
                <li>
                    <a href="{{ route('products.index') }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <span>Управление товарами</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('managers.index') }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span>Команда менеджеров</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span>Аналитика бизнеса</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        <span>Заказы магазина</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <span>Категории</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span>Пользователи</span>
                    </a>
                </li>
            </ul>
        </article>
    </section>

    <div class="settings-modal" id="settingsModal">
        <div class="settings-modal-content">
            <div class="settings-modal-header">
                <h2>Профиль</h2>
                <button class="close-modal" onclick="toggleSettingsModal()">&times;</button>
            </div>
            <form method="POST" action="{{ route('updateProfile') }}" class="form-stack">
                @csrf
                @method('PATCH')
                <div class="form-field">
                    <label for="name">Имя</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="form-field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>
            <div style="margin-top: 1rem;">
                <a href="{{ route('changePassword') }}" class="btn btn-ghost">Изменить пароль</a>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function toggleSettingsModal() {
                const modal = document.getElementById('settingsModal');
                modal.classList.toggle('active');
            }

            document.addEventListener('click', (event) => {
                const modal = document.getElementById('settingsModal');
                if (!modal || !modal.classList.contains('active')) return;
                if (event.target === modal) {
                    toggleSettingsModal();
                }
            });
        </script>
    @endpush
@endsection
