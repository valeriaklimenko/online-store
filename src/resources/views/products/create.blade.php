@extends('layouts.app')

@section('title', 'Add Product — Klavera')

@section('content')
    <div class="page-head">
        <div>
            <p class="overline">Catalog</p>
            <h1 class="section-title">Add New Product</h1>
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
                <label>Product Sizes & Measurements *</label>
                <p class="form-help">Enter quantity and measurements (in cm or inches) for each size.</p>
                <div style="overflow-x: auto; margin-top: 1rem;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                        <thead>
                            <tr style="border-bottom: 2px solid #ccc;">
                                <th style="padding: 0.75rem; text-align: left;">Size</th>
                                <th style="padding: 0.75rem; text-align: left;">Quantity</th>
                                <th style="padding: 0.75rem; text-align: left;">Chest (cm)</th>
                                <th style="padding: 0.75rem; text-align: left;">Waist (cm)</th>
                                <th style="padding: 0.75rem; text-align: left;">Hips (cm)</th>
                                <th style="padding: 0.75rem; text-align: left;">Length (cm)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sizes = ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL'];
                                $oldSizes = old('sizes', []);
                            @endphp
                            @foreach($sizes as $size)
                                <tr style="border-bottom: 1px solid #eee;">
                                    <td style="padding: 0.75rem; font-weight: 600;">{{ $size }}</td>
                                    <td style="padding: 0.75rem;">
                                        <input type="number" name="sizes[{{ $size }}][quantity]" min="0" value="{{ $oldSizes[$size]['quantity'] ?? 0 }}" style="width: 80px; padding: 0.5rem;">
                                    </td>
                                    <td style="padding: 0.75rem;">
                                        <input type="text" name="sizes[{{ $size }}][chest]" placeholder="e.g. 80" value="{{ $oldSizes[$size]['chest'] ?? '' }}" style="width: 100px; padding: 0.5rem;">
                                    </td>
                                    <td style="padding: 0.75rem;">
                                        <input type="text" name="sizes[{{ $size }}][waist]" placeholder="e.g. 70" value="{{ $oldSizes[$size]['waist'] ?? '' }}" style="width: 100px; padding: 0.5rem;">
                                    </td>
                                    <td style="padding: 0.75rem;">
                                        <input type="text" name="sizes[{{ $size }}][hips]" placeholder="e.g. 90" value="{{ $oldSizes[$size]['hips'] ?? '' }}" style="width: 100px; padding: 0.5rem;">
                                    </td>
                                    <td style="padding: 0.75rem;">
                                        <input type="text" name="sizes[{{ $size }}][length]" placeholder="e.g. 65" value="{{ $oldSizes[$size]['length'] ?? '' }}" style="width: 100px; padding: 0.5rem;">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="form-field">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_new_collection" value="1" @checked(old('is_new_collection'))>
                    New collection (shown when visitors click SHOP NOW on homepage)
                </label>
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
