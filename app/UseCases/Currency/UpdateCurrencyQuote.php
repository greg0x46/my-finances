<?php

namespace App\UseCases\Currency;

use App\Models\Currency;
use App\Models\CurrencyQuote;
use App\Services\PairQuotes\BtcDollarPairQuote;
use App\Traits\MakeableTrait;

class UpdateCurrencyQuote
{
    use MakeableTrait;

    protected Currency $currency;
    protected Currency $quoteCurrency;

    public function __construct(Currency $currency, Currency $quoteCurrency)
    {
        $this->currency = $currency;
        $this->quoteCurrency = $quoteCurrency;
    }

    public function execute(): void
    {
        $pair = BtcDollarPairQuote::make()->loadRemoteQuote();

        CurrencyQuote::create([
            'currency_id' => $this->currency->id,
            'quote_currency_id' => $this->quoteCurrency->id,
            'price' => $pair->price,
            'price_at' => $pair->priceAt
        ]);
    }
}
