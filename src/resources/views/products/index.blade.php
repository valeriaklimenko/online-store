@extends('layouts.app')

@section('title', 'Product Management — Klavera')

@section('content')
    <div class="page-head">
        <div>
            <p class="overline">Catalog</p>
            <h1 class="section-title">Product Management</h1>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($products->count())
        <div class="admin-products-grid">
            @foreach($products as $product)
                <article class="admin-product-card">
                    <div class="admin-product-card__media">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        @else
                            <span class="admin-product-card__placeholder" aria-hidden="true">📦</span>
                        @endif
                    </div>
                    <div class="admin-product-card__body">
                        @if($product->category)
                            <span class="badge">{{ $product->category->name }}</span>
                        @endif
                        <h3 class="admin-product-card__name">{{ $product->name }}</h3>
                        <p class="admin-product-card__desc">
                            {{ \Illuminate\Support\Str::limit($product->description, 110) }}
                        </p>
                        <div class="admin-product-card__footer">
                            <div>
                                <div class="admin-product-card__price">${{ number_format($product->price, 2) }}</div>
                                <p class="form-help">Stock: {{ $product->quantity }}</p>
                            </div>
                            <div class="admin-product-card__actions">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-ghost btn-small">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                      onsubmit="return confirm('Delete product «{{ $product->name }}»?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-small">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <div class="card empty-state">
            <h2 class="section-heading">No Products Found</h2>
            <p>Add your first product to start filling the showcase.</p>
            <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
        </div>
    @endif

    @if($products->hasPages())
        <div class="pagination-row">
            {{ $products->links() }}
        </div>
    @endif
@endsection
