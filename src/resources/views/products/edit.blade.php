@extends('layouts.app')

@section('title', 'Редактировать товар — Klavera')

@section('content')
    <div class="page-head">
        <div>
            <p class="overline">Каталог</p>
            <h1 class="section-title">Редактировать товар</h1>
        </div>
        <a href="{{ route('products.index') }}" class="pill-btn">← Вернуться к списку</a>
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
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="form-stack">
            @csrf
            @method('PATCH')

            <div class="form-field">
                <label for="category_id">Категория *</label>
                <select id="category_id" name="category_id" required>
                    <option value="" disabled {{ old('category_id', $product->category_id) ? '' : 'selected' }}>Выберите категорию</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-field">
                <label for="name">Название товара *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="form-field">
                <label for="description">Описание</label>
                <textarea id="description" name="description" rows="5">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="form-field">
                <label for="price">Цена *</label>
                <input type="number" id="price" name="price" step="0.01" min="0" value="{{ old('price', $product->price) }}" required>
            </div>

            <div class="form-field">
                <label for="quantity">Количество *</label>
                <input type="number" id="quantity" name="quantity" min="0" value="{{ old('quantity', $product->quantity) }}" required>
            </div>

            <div class="form-field">
                <label>Текущие изображения</label>
                @if($product->images->count())
                    <div class="media-list">
                        @foreach($product->images as $image)
                            <label class="media-thumb">
                                <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $product->name }}">
                                <span class="form-help">
                                    <input type="checkbox" name="remove_images[]" value="{{ $image->id }}">
                                    удалить
                                </span>
                            </label>
                        @endforeach
                    </div>
                @else
                    <p class="form-help">Изображения ещё не загружены.</p>
                @endif
            </div>

            <div class="form-field">
                <label for="images">Добавить новые изображения</label>
                <input type="file" id="images" name="images[]" accept="image/*" multiple>
                <p class="form-help">
                    Можно загрузить несколько новых изображений (до 4 МБ каждое). Поддерживаемые форматы: JPEG, PNG, JPG, GIF.
                </p>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Обновить товар</button>
                <a href="{{ route('products.index') }}" class="btn btn-ghost">Отмена</a>
            </div>
        </form>
    </div>
@endsection











