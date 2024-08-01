<?php

namespace Tests\Feature\UseCases;

use App\Data\DestroyTransactionData;
use App\Models\Transaction;
use App\Models\Wallet;
use App\UseCases\DestroyTransaction;
use Tests\TestCase;

class DestroyTransactionTest extends TestCase
{
    public function test_should_destroy_a_buy_transaction(): void
    {
        $transaction = Transaction::factory()->buy()->create(['amount' => '100.99999999']);
        $wallet = $transaction->wallet;

        $data = DestroyTransactionData::make(['transactionId' => $transaction->id]);
        DestroyTransaction::make(['data' => $data])->execute();

        self::assertDatabaseMissing('transactions', ['id' => $transaction->id]);
        self::assertEquals('-100.99999999', $wallet->refresh()->balance);
    }

    public function test_should_destroy_a_sell_transaction(): void
    {
        $transaction = Transaction::factory()->sell()->create(['amount' => '100.99999999']);
        $wallet = $transaction->wallet;

        $data = DestroyTransactionData::make(['transactionId' => $transaction->id]);
        DestroyTransaction::make(['data' => $data])->execute();

        self::assertDatabaseMissing('transactions', ['id' => $transaction->id]);
        self::assertEquals('100.99999999', $wallet->refresh()->balance);
    }
}
