@php
    /** @var \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection|null $currencyRates */
    $currencyRates = $currencyRates ?? collect();
    $updatedAt = $currencyRatesUpdatedAt ?? null;

    $wanted = [
        'USD' => 'US Dollar',
        'EUR' => 'Euro',
        'RUB' => 'Russian Ruble',
    ];
@endphp

<section class="rates-widget" aria-label="Currency exchange rates">
    <div class="rates-card">
        <div class="rates-top">
            <div>
                <div class="rates-title">Exchange rates</div>
                <div class="rates-subtitle">National Bank of the Republic of Belarus (NBRB)</div>
            </div>
            @if ($updatedAt)
                <div class="rates-updated">
                    Updated: {{ \Illuminate\Support\Carbon::parse($updatedAt)->format('Y-m-d H:i') }}
                </div>
            @endif
        </div>

        @php $hasAny = false; @endphp
        <div class="rates-grid">
            @foreach ($wanted as $code => $label)
                @php
                    $row = $currencyRates instanceof \Illuminate\Support\Collection ? $currencyRates->get($code) : null;
                    $value = null;
                    if ($row && isset($row->rate, $row->scale) && (float) $row->scale > 0) {
                        $value = (float) $row->rate / (float) $row->scale;
                        $hasAny = true;
                    }
                @endphp
                <div class="rate-item">
                    <div class="rate-code">{{ $code }}</div>
                    <div class="rate-value">
                        @if ($value !== null)
                            {{ number_format($value, 4) }} BYN
                        @else
                            —
                        @endif
                    </div>
                    <div class="rate-label">{{ $label }}</div>
                </div>
            @endforeach
        </div>

        @unless($hasAny)
            <div class="rates-empty">
                Rates are not loaded yet. Run <code>php artisan app:fetch-currency-rates</code> (or wait for scheduler).
            </div>
        @endunless
    </div>
</section>
