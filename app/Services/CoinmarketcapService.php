<?php

namespace App\Services;

use App\Traits\MakeableTrait;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class CoinmarketcapService
{
    use MakeableTrait;

    public function client(): PendingRequest
    {
        return Http::withHeader('X-CMC_PRO_API_KEY', config('services.coinmarketcap.api_key'))
            ->acceptJson();
    }
}
