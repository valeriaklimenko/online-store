@extends('layouts.app')

@php
    /** @var \App\Models\User $authUser */
    $authUser = auth()->user();
@endphp

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
                        <div style="margin-top: 0.75rem; display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                            <span class="line-item__price">${{ number_format($item->product->price, 2) }}</span>
                            <form method="POST" action="{{ route('basket.updateQuantity', $item->id) }}" style="display: flex; align-items: center; gap: 0.5rem;">
                                @csrf
                                @method('PATCH')
                                <label class="form-help" for="qty-{{ $item->id }}">Qty</label>
                                <input type="number" id="qty-{{ $item->id }}" name="quantity" min="1" value="{{ $item->quantity }}" style="width: 4rem;">
                                <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                <button type="submit" class="btn btn-ghost btn-small">Update</button>
                            </form>
                            <span class="form-help">Line: ${{ number_format((float)($item->product->price * $item->quantity), 2) }}</span>
                        </div>
                    </div>

                    <div class="line-item__actions">
                        <form action="{{ route('basket.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-small"
                                    onclick="return confirm('Remove this item from your basket?')">
                                Remove
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
            <div style="margin-top: 1.5rem; text-align: center;">
                <button class="btn btn-primary btn-full" type="button" style="max-width: 400px;"
                        onclick="document.getElementById('checkoutModal').classList.add('active')">
                    Place order
                </button>
            </div>
        </div>

        <p style="text-align: center; margin-top: 1.5rem;">
            <a href="{{ route('home') }}#products" class="btn btn-ghost">Continue shopping</a>
        </p>

        <div class="settings-modal" id="checkoutModal">
            <div class="settings-modal-content settings-modal-content--wide">
                <div class="settings-modal-header">
                    <h2>Checkout</h2>
                    <button type="button" class="close-modal"
                            onclick="document.getElementById('checkoutModal').classList.remove('active')"
                            aria-label="Close">&times;</button>
                </div>
                <form action="{{ route('orders.store') }}" method="POST" class="form-stack">
                    @csrf
                    <div class="form-grid-2">
                        <div class="form-field"><label>First name</label><input name="first_name" required></div>
                        <div class="form-field"><label>Last name</label><input name="last_name" required></div>
                        <div class="form-field">
                            <label>Email</label>
                            <input value="{{ $authUser->email }}" disabled>
                            <p class="form-help">Receipt will be sent to this address.</p>
                        </div>
                        <div class="form-field"><label>Phone</label><input name="phone" required></div>
                        <div class="form-field"><label>Delivery address</label><input name="delivery_address" required></div>
                        <div class="form-field"><label>City</label><input name="city" required></div>
                    </div>
                    <div class="form-field">
                        <label>Comment (optional)</label>
                        <textarea name="comment" rows="3"></textarea>
                    </div>
                    <div class="card card--muted">
                        <h3 class="section-heading" style="font-size: 1.25rem;">Your order</h3>
                        @foreach($data['items'] as $item)
                            <p>{{ $item->product->name }} — {{ $item->quantity }} × ${{ number_format($item->product->price, 2) }} = ${{ number_format((float)($item->product->price * $item->quantity), 2) }}</p>
                        @endforeach
                        <hr style="border: none; border-top: 1px solid var(--line); margin: 1rem 0;">
                        <p>Items total: <strong>${{ number_format((float)$data['total_price'], 2) }}</strong></p>
                    </div>
                    <button class="btn btn-primary" type="submit">Confirm order</button>
                </form>
            </div>
        </div>
    @endif
@endsection
