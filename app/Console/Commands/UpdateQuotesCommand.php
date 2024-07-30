<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Services\PairQuotes\BtcDollarPairQuote;
use App\UseCases\Currency\UpdateCurrencyQuote;
use Illuminate\Console\Command;

class UpdateQuotesCommand extends Command
{
    const PAIRS = [
        'BTC' => ['USD']
    ];

    protected $signature = 'app:update-quotes-command';

    protected $description = 'Update pair quotes command';

    public function handle()
    {
        foreach (self::PAIRS as $base => $quotes) {
            foreach ($quotes as $quote) {
                $this->info("Updating: $base => $quote");
                $baseCurrency = Currency::where('code', $base)->firstOrFail();
                $quoteCurrency = Currency::where('code', $quote)->firstOrFail();
                UpdateCurrencyQuote::make(['currency' => $baseCurrency, 'quoteCurrency' => $quoteCurrency])->execute();
                $this->info("Updated: $base => $quote ");
            }
        }
    }
}
