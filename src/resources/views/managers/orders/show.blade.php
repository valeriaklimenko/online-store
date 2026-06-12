@extends('layouts.app')

@section('title', 'Manage Order — Klavera')

@section('content')
    <a href="{{ route('manage.orders.index') }}" class="btn btn-ghost" style="margin-bottom: 1.5rem;">← Back to orders</a>

    <div class="card" style="margin-bottom: 1.25rem;">
        <p class="overline">Order</p>
        <h2 class="section-heading" style="font-size: 1.75rem;">{{ $order->order_code }}</h2>
        <p>Status: <strong id="order-status">{{ $statusLabels[$order->status] ?? $order->status }}</strong></p>
        <p id="picked-counter" class="form-help">
            Picked {{ $order->items->where('is_picked', true)->count() }} of {{ $order->items->count() }} items
        </p>
    </div>

    <div class="card">
        <table class="table-shell">
            <thead>
            <tr>
                <th>Pick</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>
                        <input
                            type="checkbox"
                            class="pick-checkbox"
                            data-item-id="{{ $item->id }}"
                            @checked($item->is_picked)
                        >
                    </td>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format((float)$item->unit_price, 2) }}</td>
                    <td>${{ number_format((float)$item->line_total, 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.pick-checkbox').forEach((checkbox) => {
            checkbox.addEventListener('change', async function () {
                const itemId = this.dataset.itemId;
                const picked = this.checked ? 1 : 0;

                const response = await fetch('{{ url('/manage/order-items') }}/' + itemId + '/pick', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ picked }),
                });

                const payload = await response.json();
                if (!payload.success) {
                    this.checked = !this.checked;
                    return;
                }

                document.getElementById('picked-counter').textContent =
                    `Picked ${payload.picked_count} of ${payload.items_count} items`;
                document.getElementById('order-status').textContent = payload.order_status;
            });
        });
    </script>
@endpush
