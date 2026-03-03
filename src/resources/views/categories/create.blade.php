@extends('layouts.app')

@section('title', 'Add Category — Klavera')

@section('content')
    <div class="page-head">
        <div>
            <p class="overline">Catalog</p>
            <h1 class="section-title">Add New Category</h1>
        </div>
        <a href="{{ route('categories.index') }}" class="pill-btn">← Back to Category Management</a>
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
        <form action="{{ route('categories.store') }}" method="POST" class="form-stack">
            @csrf

            <div class="form-field">
                <label for="name">Category Name *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="form-field">
                <label for="slug">Slug (URL)</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug') }}"
                       placeholder="Auto-generated from name">
                <p class="form-help">Leave empty for auto-generation</p>
            </div>

            <div class="form-field">
                <label for="parent_id">Parent Category</label>
                <select id="parent_id" name="parent_id">
                    <option value="">— No parent category (root)</option>
                    @php
                        $categoryService = app(\App\Services\CategoryService::class);
                        $categoriesForSelect = $categoryService->getCategoriesForSelect();
                    @endphp
                    @foreach($categoriesForSelect as $id => $name)
                        <option value="{{ $id }}" @selected(old('parent_id') == $id)>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save Category</button>
                <a href="{{ route('categories.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
@endsection

