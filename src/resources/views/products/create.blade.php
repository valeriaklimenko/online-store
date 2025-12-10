@extends('layouts.app')

@section('title', 'Добавить товар — Klavera')

@section('content')
    <div class="page-head">
        <div>
            <p class="overline">Каталог</p>
            <h1 class="section-title">Добавить новый товар</h1>
        </div>
        <a href="{{ route('products.index') }}" class="pill-btn">← К управлению товарами</a>
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

    @if ($categories->isEmpty())
        <div class="alert alert-danger">
            Сначала добавьте категории (через сидер или панель администратора), чтобы можно было создать товар.
        </div>
    @endif

    <div class="card">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="form-stack">
            @csrf

            <div class="form-field">
                <label for="category_id">Категория *</label>
                <select id="category_id" name="category_id" @disabled($categories->isEmpty()) required>
                    <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Выберите категорию</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-field">
                <label for="name">Название товара *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="form-field">
                <label for="description">Описание</label>
                <textarea id="description" name="description" rows="5">{{ old('description') }}</textarea>
            </div>

            <div class="form-field">
                <label for="price">Цена *</label>
                <input type="number" id="price" name="price" step="0.01" min="0" value="{{ old('price') }}" required>
            </div>

            <div class="form-field">
                <label for="quantity">Количество *</label>
                <input type="number" id="quantity" name="quantity" min="0" value="{{ old('quantity', 0) }}" required>
            </div>

            <div class="form-field">
                <label for="images">Изображения</label>
                <input type="file" id="images" name="images[]" accept="image/*" multiple>
                <p class="form-help">Можно загрузить несколько изображений (до 4 МБ каждое). Поддерживаемые форматы: JPEG, PNG, JPG, GIF.</p>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Сохранить товар</button>
                <a href="{{ route('products.index') }}" class="btn btn-ghost">Отмена</a>
            </div>
        </form>
    </div>
@endsection

