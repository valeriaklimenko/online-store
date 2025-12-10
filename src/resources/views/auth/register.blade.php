@extends('layouts.app')

@section('title', 'Регистрация — Klavera')

@section('content')
    <div class="auth-shell">
        <div class="auth-card">
            <div class="auth-heading">
                <p class="overline">Новый аккаунт</p>
                <h1>Создайте профиль</h1>
                <p style="color: var(--text-muted); font-size: 0.95rem;">Это займёт меньше минуты</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin: 0; padding-left: 1.2rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="form-stack">
                @csrf
                <div class="form-field">
                    <label for="name">Имя</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="form-field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="form-field">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-field">
                    <label for="password_confirmation">Повторите пароль</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-primary btn-full">Зарегистрироваться</button>
            </form>

            <div class="auth-meta">
                Уже есть аккаунт? <a href="{{ route('login') }}">Войдите</a>
            </div>
        </div>
    </div>
@endsection
