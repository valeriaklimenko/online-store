@extends('layouts.app')

@section('title', 'Edit Product — Klavera')

@section('content')
    <div class="page-head">
        <div>
            <p class="overline">Catalog</p>
            <h1 class="section-title">Edit Product</h1>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-ghost">← Back to products</a>
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
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
              class="form-stack">
            @csrf
            @method('PATCH')

            <div class="form-field">
                <label for="category_id">Category *</label>
                <select id="category_id" name="category_id" required>
                    <option value="" disabled {{ old('category_id', $product->category_id) ? '' : 'selected' }}>Select
                        category
                    </option>
                    @foreach($categories as $category)
                        <option
                            value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-field">
                <label for="name">Product Name *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="form-field">
                <label for="description">Description</label>
                <textarea id="description" name="description"
                          rows="5">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="form-field">
                <label for="price">Price *</label>
                <input type="number" id="price" name="price" step="0.01" min="0"
                       value="{{ old('price', $product->price) }}" required>
            </div>

            <div class="form-field">
                <label>Sizes and quantity</label>
                <p class="form-help">Please indicate how many pieces of each size are in stock.</p>
                <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                    <thead>
                    <tr style="border-bottom: 2px solid #ccc;">
                        <th style="padding: 0.75rem; text-align: left;">Размер</th>
                        <th style="padding: 0.75rem; text-align: left;">Количество</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($allSizes as $size)
                        @php
                            $qty = old('size_quantities.'.$size->id, $sizeQuantities[$size->id] ?? 0);
                        @endphp
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 0.75rem; font-weight: 600;">{{ $size->name }}</td>
                            <td style="padding: 0.75rem;">
                                <input
                                    type="number"
                                    name="size_quantities[{{ $size->id }}]"
                                    min="0"
                                    value="{{ $qty }}"
                                    style="width: 80px; padding: 0.5rem;"
                                >
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="form-field">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_new_collection"
                           value="1" @checked(old('is_new_collection', $product->is_new_collection))>
                    New collection (shown when visitors click SHOP NOW on homepage)
                </label>
            </div>

            <div class="form-field">
                <label>Current Images</label>
                @if($product->images->count())
                    <div class="media-list">
                        @foreach($product->images as $image)
                            <label class="media-thumb">
                                <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $product->name }}">
                                <span class="form-help">
                                    <input type="checkbox" name="remove_images[]" value="{{ $image->id }}">
                                    delete
                                </span>
                            </label>
                        @endforeach
                    </div>
                @else
                    <p class="form-help">No images uploaded yet.</p>
                @endif
            </div>

            <div class="form-field">
                <label for="images">Add New Images</label>
                <input type="file" id="images" name="images[]" accept="image/*" multiple>
                <p class="form-help">
                    You can upload multiple new images (up to 4 MB each). Supported formats: JPEG, PNG, JPG, GIF.
                </p>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Product</button>
                <a href="{{ route('products.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
@endsection
