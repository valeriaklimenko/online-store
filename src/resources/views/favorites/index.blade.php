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
                        <p class="line-item__price" style="margin-top: 0.75rem;">
                            ${{ number_format($item->product->price, 2) }}</p>
                    </div>

                    <div class="line-item__actions">
                        <button type="button" class="btn btn-primary btn-small js-open-size-picker"
                                data-product-id="{{ $item->product->id }}"
                                data-product-name="{{ $item->product->name }}"
                                data-sizes='@json($item->product->sizes->map(fn($s) => ["id" => $s->id, "name" => $s->name, "stock" => ($s->pivot->quantity ?? 0)]))'>
                            Add to basket
                        </button>
                        <form action="{{ route('favorites.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-small"
                                    onclick="return confirm('Remove from favorites?')">Remove
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

    @include('partials.size-picker-modal')
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('sizePickerModal');
            const list = document.getElementById('sizePickerList');
            const productIdInput = document.getElementById('sizePickerProductId');
            const sizeIdInput = document.getElementById('sizePickerSizeId');
            const submitBtn = document.getElementById('sizePickerSubmit');
            const nameEl = document.getElementById('sizePickerProductName');
            const form = document.getElementById('sizePickerForm');
            const warning = document.getElementById('sizePickerWarning');
            let selectedSizeId = null;

            const openModal = (btn) => {
                selectedSizeId = null;
                sizeIdInput.value = '';
                submitBtn.disabled = true;
                warning.hidden = true;
                warning.textContent = '';
                list.innerHTML = '';

                const sizes = JSON.parse(btn.dataset.sizes || '[]');
                productIdInput.value = btn.dataset.productId;
                nameEl.textContent = btn.dataset.productName;

                sizes.forEach((size) => {
                    const available = size.stock > 0;
                    const el = document.createElement('button');
                    el.type = 'button';
                    el.className = 'size-option' + (available ? '' : ' unavailable');
                    el.textContent = size.name;
                    el.dataset.sizeId = size.id;
                    el.disabled = !available;

                    if (available) {
                        el.addEventListener('click', () => {
                            list.querySelectorAll('.size-option').forEach(b => b.classList.remove('is-active'));
                            el.classList.add('is-active');
                            selectedSizeId = size.id;
                            sizeIdInput.value = size.id;
                            warning.hidden = true;
                            submitBtn.disabled = false;
                        });
                    }

                    list.appendChild(el);
                });

                modal.classList.add('active');
            };

            const closeModal = () => modal.classList.remove('active');

            document.querySelectorAll('.js-open-size-picker').forEach(btn => {
                btn.addEventListener('click', () => openModal(btn));
            });

            modal.querySelectorAll('[data-size-modal-close]').forEach(el => {
                el.addEventListener('click', closeModal);
            });

            modal.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });

            form?.addEventListener('submit', (event) => {
                event.preventDefault();

                if (!selectedSizeId) {
                    warning.textContent = 'Please select a size before adding this item to your basket.';
                    warning.hidden = false;
                    return;
                }

                submitBtn.disabled = true;

                fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json'},
                })
                    .then(async response => {
                        const data = await response.json().catch(() => ({}));
                        if (!response.ok) throw new Error(data.message || 'Could not add this item to your basket. Please try again.');
                        return data;
                    })
                    .then(data => {
                        if (data.success) {
                            window.location.href = '{{ route('basket.index') }}';
                            return;
                        }

                        throw new Error(data.message || 'Could not add this item to your basket. Please try again.');
                    })
                    .catch(error => {
                        warning.textContent = error.message || 'Could not add this item to your basket. Please try again.';
                        warning.hidden = false;
                        submitBtn.disabled = false;
                    });
            });
        });
    </script>
@endpush
