<?php

namespace App\Services;

use App\Models\CurrencyRate;
use Illuminate\Support\Facades\Http;

class CurrencyRatesService
{
    public function updateRates()
    {
        $response = Http::get('https://www.nbrb.by/api/exrates/rates?periodicity=0');

        if ($response->successful()) {
            $rates = $response->json();

            foreach ($rates as $rate) {
                CurrencyRate::updateOrCreate(
                    ['code' => $rate['Cur_Abbreviation']],
                    [
                        'name' => $rate['Cur_Name'],
                        'rate' => $rate['Cur_OfficialRate'],
                        'scale' => $rate['Cur_Scale'],
                        'updated_at' => now()
                    ]
                );
            }
            return true;
        }
        return false;
    }

    public function getRate($code)
    {
        $rate = CurrencyRate::where('code', $code)->first();
        return $rate ? $rate->rate / $rate->scale : null;
    }
}
