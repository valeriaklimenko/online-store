<?php

namespace App\Console\Commands;

use App\Services\CurrencyRatesService;
use Illuminate\Console\Command;

class FetchCurrencyRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-currency-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(CurrencyRatesService $service)
    {
        $service->updateRates()
            ? $this->info('NRB currency rates updated successfully')
            : $this->error('Error fetching NRB currency rates');
    }
}
