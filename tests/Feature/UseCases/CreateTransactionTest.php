<?php

namespace Tests\Feature\UseCases;

use App\Data\CreateTransactionData;
use App\Models\Transaction;
use App\Models\Wallet;
use App\UseCases\CreateTransaction;
use Tests\TestCase;

class CreateTransactionTest extends TestCase
{
    public function test_should_create_a_buy_transaction(): void
    {
        $wallet = Wallet::factory()->create(['balance' => 10.1]);

        $data = CreateTransactionData::make([
            'walletId' => $wallet->id,
            'type' => Transaction::TYPE_BUY,
            'amount' => 100.10000009,
            'unitPrice' => 2.99999999,
            'date' => '2020-10-10 00:00:00',
        ]);

        $transaction = CreateTransaction::make(['data' => $data])->execute();

        self::assertNotNull($transaction->id);
        self::assertEquals($wallet->id, $transaction->wallet_id);
        self::assertEquals(Transaction::TYPE_BUY, $transaction->type);
        self::assertEquals('100.10000009', $transaction->amount);
        self::assertEquals('2.99999999', $transaction->unit_price);
        self::assertEquals('2020-10-10 00:00:00', $transaction->date->format('Y-m-d H:i:s'));
        self::assertEquals('110.20000009', $wallet->refresh()->balance);
    }

    public function test_should_create_a_sell_transaction(): void
    {
        $wallet = Wallet::factory()->create(['balance' => 10.1]);

        $data = CreateTransactionData::make([
            'walletId' => $wallet->id,
            'type' => Transaction::TYPE_SELL,
            'amount' => 100.10000009,
            'unitPrice' => 2.99999999,
            'date' => '2020-10-10 00:00:00',
        ]);

        $transaction = CreateTransaction::make(['data' => $data])->execute();

        self::assertNotNull($transaction->id);
        self::assertEquals($wallet->id, $transaction->wallet_id);
        self::assertEquals(Transaction::TYPE_SELL, $transaction->type);
        self::assertEquals('100.10000009', $transaction->amount);
        self::assertEquals('2.99999999', $transaction->unit_price);
        self::assertEquals('2020-10-10 00:00:00', $transaction->date->format('Y-m-d H:i:s'));
        self::assertEquals('-90.00000009', $wallet->refresh()->balance);
    }
}
