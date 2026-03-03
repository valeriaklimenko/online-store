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
        <div class="products-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
            @foreach($products as $product)
                <article class="product-card" style="cursor: default;">
                    <div class="product-image" style="height: 220px;">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        @else
                            <span>📦</span>
                        @endif
                    </div>
                    <div class="product-info">
                        @if($product->category)
                            <span class="badge" style="align-self: flex-start; margin-bottom: 0.5rem;">
                                {{ $product->category->name }}
                            </span>
                        @endif
                        <h3 class="product-name">{{ $product->name }}</h3>
                        <p class="product-description">
                            {{ \Illuminate\Support\Str::limit($product->description, 110) }}
                        </p>
                        <div class="product-footer">
                            <div>
                                <span class="product-price">${{ number_format($product->price, 2) }}</span>
                                <p class="product-meta">Stock: {{ $product->quantity }}</p>
                            </div>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-ghost">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete product {{ $product->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-primary">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <div class="card empty-state">
            <h3 class="section-heading">No Products Found</h3>
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
