@extends('layouts.app')

@section('title', 'Edit Category — Klavera')

@section('content')
    <div class="page-head">
        <div>
            <p class="overline">Catalog</p>
            <h1 class="section-title">Edit Category</h1>
        </div>
        <a href="{{ route('categories.index') }}" class="btn btn-ghost">← Back to categories</a>
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
        <form action="{{ route('categories.update', $category->id) }}" method="POST" class="form-stack">
            @csrf
            @method('PATCH')

            <div class="form-field">
                <label for="name">Category Name *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required>
            </div>

            <div class="form-field">
                <label for="slug">Slug (URL)</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug', $category->slug) }}"
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
                        // Remove current category and its children from options
                        $excludeIds = [$category->id];
                        $allCategories = $categoryService->getAllCategories();
                        $children = $allCategories->where('parent_id', $category->id);
                        foreach ($children as $child) {
                            $excludeIds[] = $child->id;
                        }
                    @endphp
                    @foreach($categoriesForSelect as $id => $name)
                        @if(!in_array($id, $excludeIds))
                            <option value="{{ $id }}" @selected(old('parent_id', $category->parent_id) == $id)>
                                {{ $name }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Category</button>
                <a href="{{ route('categories.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
@endsection

