@extends('layouts.app')

@section('title', 'Favorites — Klavera')

@section('content')
    <div class="page-head">
        <h1 class="section-heading">Favorites</h1>
    </div>

    @if(session('success'))
        <div style="background: #10b981; color: white; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #ef4444; color: white; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem;">
            {{ session('error') }}
        </div>
    @endif

    @if($data['items']->isEmpty())
        <div class="empty-state">
            <h2 class="section-heading">Favorites is empty</h2>
            <p>Add products to favorites to save them for later.</p>
            <a href="{{ route('home') }}" class="pill-btn pill-btn--solid" style="margin-top: 1rem; display: inline-block;">
                Go to catalog
            </a>
        </div>
    @else
        <div style="display: grid; gap: 1.5rem;">
            @foreach($data['items'] as $item)
                <div class="card" style="display: flex; gap: 1.5rem; align-items: center;">
                    <div style="flex-shrink: 0;">
                        @php
                            $cover = $item->product->image ?? optional($item->product->images->first())->path;
                        @endphp
                        @if($cover)
                            <img
                                src="{{ asset('storage/' . $cover) }}"
                                alt="{{ $item->product->name }}"
                                style="width: 120px; height: 120px; object-fit: cover; border-radius: 12px;"
                            >
                        @else
                            <div style="width: 120px; height: 120px; background: var(--accent-soft); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                                📦
                            </div>
                        @endif
                    </div>

                    <div style="flex: 1;">
                        <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">
                            <a href="{{ route('products.show', $item->product->id) }}" style="color: inherit; text-decoration: none;">
                                {{ $item->product->name }}
                            </a>
                        </h3>
                        @if($item->product->description)
                            <p style="color: var(--text-muted); margin-bottom: 0.5rem; font-size: 0.95rem;">
                                {{ \Illuminate\Support\Str::limit($item->product->description, 100) }}
                            </p>
                        @endif
                        @if($item->product->category)
                            <span class="badge" style="margin-bottom: 0.5rem; display: inline-block;">
                                {{ $item->product->category->name }}
                            </span>
                        @endif
                        <div style="margin-top: 0.75rem; display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <span style="font-size: 1.25rem; font-weight: 600; color: var(--accent);">
                                    ${{ number_format($item->product->price, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div style="flex-shrink: 0; display: flex; flex-direction: column; gap: 0.5rem;">
                        <form action="{{ route('basket.store') }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                            <button type="submit" class="pill-btn pill-btn--solid">
                                Add to Basket
                            </button>
                        </form>
                        <form action="{{ route('favorites.destroy', $item->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="pill-btn" style="color: #ef4444; border-color: #ef4444;"
                                    onclick="return confirm('Are you sure you want to remove this item from favorites?')">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 1.5rem; text-align: center;">
            <a href="{{ route('home') }}" class="pill-btn">
                Continue shopping
            </a>
        </div>
    @endif
@endsection
