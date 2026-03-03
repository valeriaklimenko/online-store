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
        <div class="card">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--line);">
                        <th style="padding: 1rem; text-align: left;">ID</th>
                        <th style="padding: 1rem; text-align: left;">Name</th>
                        <th style="padding: 1rem; text-align: left;">Parent Category</th>
                        <th style="padding: 1rem; text-align: left;">Products</th>
                        <th style="padding: 1rem; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $rootCategories = $categories->whereNull('parent_id')->sortBy('name');
                    @endphp
                    @foreach($rootCategories as $category)
                        @include('categories.partials.category-row', ['category' => $category, 'categories' => $categories, 'level' => 0])
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="card empty-state">
            <h3 class="section-heading">No Categories Found</h3>
            <p>Add your first category to start structuring the catalog.</p>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">Add Category</a>
        </div>
    @endif
@endsection
