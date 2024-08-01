<?php

namespace Tests\Feature\UseCases;

use Tests\TestCase;
use App\Models\Currency;
use App\Data\CreateWalletData;
use App\UseCases\CreateWallet;

class CreateWalletTest extends TestCase
{
    public function test_should_return_balance()
    {
        $currency = Currency::factory()->create();
        $data = CreateWalletData::make([
            'name' => 'test',
            'initialBalance' => '100.99999999',
            'currencyId' => $currency->id
        ]);

        $wallet = CreateWallet::make(['data' => $data])->execute();

        self::assertNotNull($wallet->id);
        self::assertEquals('test', $wallet->name);
        self::assertEquals($currency->id, $wallet->currency_id);
        self::assertEquals('100.99999999', $wallet->initial_balance);
        self::assertEquals('100.99999999', $wallet->balance);
    }
}
