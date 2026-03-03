@extends('layouts.app')

@section('title', 'Add Product — Klavera')

@section('content')
    <div class="page-head">
        <div>
            <p class="overline">Catalog</p>
            <h1 class="section-title">Add New Product</h1>
        </div>
        <a href="{{ route('products.index') }}" class="pill-btn">← Back to Product Management</a>
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
            Please add categories first (via seeder or admin panel) to create a product.
        </div>
    @endif

    <div class="card">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="form-stack">
            @csrf

            <div class="form-field">
                <label for="category_id">Category *</label>
                <select id="category_id" name="category_id" @disabled($categories->isEmpty()) required>
                    <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Select category</option>
                    @php
                        $categoryService = app(\App\Services\CategoryService::class);
                        $categoriesForSelect = $categoryService->getCategoriesForSelect();
                    @endphp
                    @foreach($categoriesForSelect as $id => $name)
                        <option value="{{ $id }}" @selected(old('category_id') == $id)>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-field">
                <label for="name">Product Name *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="form-field">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5">{{ old('description') }}</textarea>
            </div>

            <div class="form-field">
                <label for="price">Price *</label>
                <input type="number" id="price" name="price" step="0.01" min="0" value="{{ old('price') }}" required>
            </div>

            <div class="form-field">
                <label for="quantity">Quantity *</label>
                <input type="number" id="quantity" name="quantity" min="0" value="{{ old('quantity', 0) }}" required>
            </div>

            <div class="form-field">
                <label for="images">Images</label>
                <input type="file" id="images" name="images[]" accept="image/*" multiple>
                <p class="form-help">You can upload multiple images (up to 4 MB each). Supported formats: JPEG, PNG,
                    JPG, GIF.</p>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save Product</button>
                <a href="{{ route('products.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
@endsection
