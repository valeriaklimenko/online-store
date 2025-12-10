@extends('layouts.app')

@section('title', 'Вход — Klavera')

@section('content')
    <div class="auth-shell">
        <div class="auth-card">
            <div class="auth-heading">
                <p class="overline">Добро пожаловать</p>
                <h1>Войдите в Klavera</h1>
                <p style="color: var(--text-muted); font-size: 0.95rem;">Продолжите покупки и управляйте профилем</p>
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

            <form method="POST" action="{{ route('login') }}" class="form-stack">
                @csrf
                <div class="form-field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="form-field">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-full">Войти</button>
            </form>

            <div class="auth-meta">
                Нет аккаунта? <a href="{{ route('register') }}">Создайте его</a>
            </div>
        </div>
    </div>
@endsection
