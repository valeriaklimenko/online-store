@extends('layouts.app')

@section('title', 'Category Management — Klavera')

@section('content')
    <div class="page-head">
        <div>
            <p class="overline">Catalog</p>
            <h1 class="section-title">Category Management</h1>
        </div>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">Add Category</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error') || $errors->has('error'))
        <div class="alert alert-danger">{{ session('error') ?? $errors->first('error') }}</div>
    @endif

    @if($categories->count())
        <div class="card category-tree-panel">
            <div class="category-tree__row category-tree__row--head" aria-hidden="true">
                <span class="category-tree__name-wrap"><strong class="form-help" style="text-transform: uppercase; letter-spacing: 0.12em;">Category</strong></span>
                <span class="category-tree__meta category-tree__meta--id">ID</span>
                <span class="category-tree__meta category-tree__meta--parent">Parent</span>
                <span class="category-tree__meta">Products</span>
                <span class="category-tree__actions"></span>
            </div>
            <ul class="category-tree" role="tree" aria-label="Category hierarchy">
                @php
                    $rootCategories = $categories->whereNull('parent_id')->sortBy('name');
                @endphp
                @foreach($rootCategories as $category)
                    @include('categories.partials.category-tree-node', [
                        'category' => $category,
                        'categories' => $categories,
                        'level' => 0,
                    ])
                @endforeach
            </ul>
        </div>
    @else
        <div class="card empty-state">
            <h2 class="section-heading">No Categories Found</h2>
            <p>Add your first category to start structuring the catalog.</p>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">Add Category</a>
        </div>
    @endif
@endsection
