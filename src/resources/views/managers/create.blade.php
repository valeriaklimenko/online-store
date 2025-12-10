@extends('layouts.app')

@section('title', 'Новый менеджер — Klavera')

@section('content')
    <div class="page-head">
        <div>
            <p class="overline">Команда магазина</p>
            <h1 class="section-title">Добавить менеджера</h1>
        </div>
        <a href="{{ route('managers.index') }}" class="pill-btn">← Назад к списку</a>
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

    <div class="card">
        <form action="{{ route('managers.store') }}" method="POST" class="form-stack">
            @csrf

            <div class="form-field">
                <label for="name">Имя менеджера *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="form-field">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-field">
                <label for="password">Пароль *</label>
                <input type="password" id="password" name="password" required minlength="8">
                <p class="form-help">Минимальная длина пароля — 8 символов.</p>
            </div>

            <div class="form-field">
                <label for="password_confirmation">Подтверждение пароля *</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Создать менеджера</button>
                <a href="{{ route('managers.index') }}" class="btn btn-ghost">Отмена</a>
            </div>
        </form>
    </div>
@endsection














