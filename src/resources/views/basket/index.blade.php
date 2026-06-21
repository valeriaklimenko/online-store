@extends('layouts.app')

@section('title', 'Basket — Klavera')

@section('content')
    <div class="page-head">
        <h1 class="section-heading">Basket</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($data['items']->isEmpty())
        <div class="card empty-state">
            <h2 class="section-heading">Basket is empty</h2>
            <p>Add products to your basket to place an order.</p>
            <a href="{{ route('home') }}#products" class="btn btn-primary">Go to catalog</a>
        </div>
    @else
        <div class="line-items-stack">
            @foreach($data['items'] as $item)
                @php
                    $cover = $item->product->image ?? optional($item->product->images->first())->path;
                    $maxQty = (int) optional($item->product->sizes->firstWhere('id', $item->size_id)?->pivot)->quantity ?? 100;
                @endphp
                <div class="card line-item">
                    <div class="line-item__media">
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
                        @if($item->size)
                            <span class="badge">{{ $item->size->name }}</span>
                        @endif
                        @if($item->product->category)
                            <span class="badge">{{ $item->product->category->name }}</span>
                        @endif
                        <div
                            style="margin-top: 0.75rem; display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                            <span class="line-item__price">${{ number_format($item->product->price, 2) }}</span>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">

                                <form action="{{ route('basket.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="quantity" value="{{ $item->quantity - 1 }}">
                                    <button type="submit" class="btn btn-ghost btn-small"
                                            aria-label="Decrease quantity" {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                        −
                                    </button>
                                </form>

                                <span>{{ $item->quantity }}</span>

                                <form action="{{ route('basket.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                    <button type="submit" class="btn btn-ghost btn-small"
                                            aria-label="Increase quantity" @disabled($item->quantity >= $maxQty)>+
                                    </button>
                                </form>
                            </div>
                            <span class="form-help">In stock: {{ $maxQty }}</span>
                            <span
                                class="form-help">Line: ${{ number_format((float)($item->product->price * $item->quantity), 2) }}</span>
                        </div>
                    </div>

                    <div class="line-item__actions">
                        <form action="{{ route('basket.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-small"
                                    onclick="return confirm('Remove this item from your basket?')">Remove
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="card basket-summary">
            <div class="basket-summary__row">
                <div>
                    <p class="form-help">Items in basket</p>
                    <p style="margin: 0; font-weight: 500;">{{ $data['items_count'] }} items</p>
                </div>
                <div style="text-align: right;">
                    <p class="form-help">Total</p>
                    <p class="basket-summary__total">${{ number_format($data['total_price'], 2) }}</p>
                </div>
            </div>
        </div>

        <p style="text-align: center; margin-top: 1.5rem;">
            <a href="{{ route('home') }}#products" class="btn btn-ghost">Continue shopping</a>
        </p>
    @endif
@endsection
