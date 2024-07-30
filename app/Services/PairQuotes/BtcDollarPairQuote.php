<?php

namespace App\Services\PairQuotes;

use App\Services\CoinmarketcapService;
use App\Traits\MakeableTrait;
use Carbon\Carbon;

class BtcDollarPairQuote
{
    use MakeableTrait;

    public string $price;
    public Carbon $priceAt;

    public function loadRemoteQuote(): static
    {
        $response = CoinmarketcapService::make()->client()->get(
            'https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest',
            ['symbol' => 'BTC']

        );

        $this->price = (string) $response->json('data.BTC.quote.USD.price');
        $this->priceAt = Carbon::parse($response->json('data.BTC.quote.USD.last_updated'));

        return $this;
    }
}
