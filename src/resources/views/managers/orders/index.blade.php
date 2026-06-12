@extends('layouts.app')

@section('title', 'Order Management — Klavera')

@section('content')
    <div class="page-head">
        <div>
            <p class="overline">Operations</p>
            <h1 class="section-heading">Order management</h1>
        </div>
    </div>

    <div class="card" style="margin-bottom: 1.25rem;">
        <form method="GET" action="{{ route('manage.orders.index') }}" class="form-stack">
            <div class="form-grid-2">
                <div class="form-field">
                    <label>Status</label>
                    <select name="status">
                        <option value="">All</option>
                        @foreach($statusLabels as $value => $label)
                            <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-field">
                    <label>Date from</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}">
                </div>
                <div class="form-field">
                    <label>Date to</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}">
                </div>
            </div>
            <button class="btn btn-primary" type="submit">Apply filters</button>
        </form>
    </div>

    <div class="card" style="margin-bottom: 1.25rem;">
        <form method="POST" action="{{ route('manage.settings.deliveryFee') }}" class="form-stack">
            @csrf
            <div class="form-field" style="max-width: 240px;">
                <label>Delivery fee</label>
                <input type="number" step="0.01" min="0" name="delivery_fee" value="{{ number_format($deliveryFee, 2, '.', '') }}">
            </div>
            <button class="btn btn-ghost" type="submit">Save fee</button>
        </form>
    </div>

    <div class="card">
        <table class="table-shell">
            <thead>
            <tr>
                <th>Status</th>
                <th>Order code</th>
                <th>User</th>
                <th>Created</th>
                <th>Total</th>
                <th>Picked</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td><span class="order-status-badge">{{ $statusLabels[$order->status] ?? $order->status }}</span></td>
                    <td>{{ $order->order_code }}</td>
                    <td>{{ $order->email }}</td>
                    <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                    <td>${{ number_format((float)$order->total_amount, 2) }}</td>
                    <td>{{ $order->picked_items_count }} / {{ $order->items_count }}</td>
                    <td>
                        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; align-items: center;">
                            <a href="{{ route('manage.orders.show', $order) }}" class="btn btn-ghost btn-small">View</a>
                            <form method="POST" action="{{ route('manage.orders.updateStatus', $order) }}">
                                @csrf
                                <select name="status" onchange="this.form.submit()" style="max-width: 140px;">
                                    @foreach($statusLabels as $value => $label)
                                        <option value="{{ $value }}" @selected($order->status === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </form>
                            <form method="POST" action="{{ route('manage.orders.ship', $order) }}">
                                @csrf
                                <button class="btn btn-primary btn-small" type="submit" @disabled($order->status !== 'confirmed')>Ship</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination-row">{{ $orders->links() }}</div>
    </div>
@endsection
