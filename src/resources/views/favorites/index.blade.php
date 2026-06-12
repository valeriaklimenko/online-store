@extends('layouts.app')

@section('title', 'Favorites — Klavera')

@section('content')
    <div class="page-head">
        <h1 class="section-heading">Favorites</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($data['items']->isEmpty())
        <div class="card empty-state">
            <h2 class="section-heading">No favorites yet</h2>
            <p>Save products you love to find them here later.</p>
            <a href="{{ route('home') }}#products" class="btn btn-primary">Go to catalog</a>
        </div>
    @else
        <div class="line-items-stack">
            @foreach($data['items'] as $item)
                <div class="card line-item">
                    <div class="line-item__media">
                        @php
                            $cover = $item->product->image ?? optional($item->product->images->first())->path;
                        @endphp
                        @if($cover)
                            <img src="{{ asset('storage/' . $cover) }}" alt="{{ $item->product->name }}">
                        @else
                            <span class="line-item__placeholder" aria-hidden="true">📦</span>
                        @endif
                    </div>

                    <div class="line-item__body">
                        <h3 class="line-item__title">
                            <a href="{{ route('products.show', $item->product->id) }}">{{ $item->product->name }}</a>
                        </h3>
                        @if($item->product->description)
                            <p class="form-help">{{ \Illuminate\Support\Str::limit($item->product->description, 100) }}</p>
                        @endif
                        @if($item->product->category)
                            <span class="badge">{{ $item->product->category->name }}</span>
                        @endif
                        <p class="line-item__price" style="margin-top: 0.75rem;">${{ number_format($item->product->price, 2) }}</p>
                    </div>

                    <div class="line-item__actions">
                        <form action="{{ route('basket.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                            <button type="submit" class="btn btn-primary btn-small">Add to basket</button>
                        </form>
                        <form action="{{ route('favorites.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-small"
                                    onclick="return confirm('Remove from favorites?')">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <p style="text-align: center; margin-top: 1.5rem;">
            <a href="{{ route('home') }}#products" class="btn btn-ghost">Continue shopping</a>
        </p>
    @endif
@endsection
