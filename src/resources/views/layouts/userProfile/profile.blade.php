@extends('layouts.app')

@section('title', 'Профиль — ' . $user->name)

@section('content')
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <section class="profile-grid">
        <article class="card profile-card">
            <p class="overline">Покупатель</p>
            <h1>{{ $user->name }}</h1>
            <p style="color: var(--text-muted); margin-bottom: 0.75rem;">{{ $user->email }}</p>
            <div style="margin-top: 1.5rem; display: flex; gap: 0.5rem;">
                <button type="button" class="pill-btn" onclick="toggleSettingsModal()">Настройки</button>
                <a href="{{ route('changePassword') }}" class="pill-btn">Пароль</a>
            </div>
        </article>

        <article class="card profile-menu-card">
            <h2>Мой аккаунт</h2>
            <ul class="profile-menu">
                <li>
                    <a href="#">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        <span>Текущие заказы</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span>История покупок</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        <span>Способы оплаты</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span>Поддержка</span>
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
