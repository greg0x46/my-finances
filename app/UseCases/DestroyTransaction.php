<?php

namespace App\UseCases;

use App\Data\DestroyTransactionData;
use App\Models\Transaction;
use App\Traits\MakeableTrait;
use Illuminate\Support\Facades\DB;

class DestroyTransaction
{
    use MakeableTrait;

    protected DestroyTransactionData $data;

    public function __construct(DestroyTransactionData $data)
    {
        $this->data = $data;
    }

    public function execute(): void
    {
        $transaction = Transaction::with('wallet')->findOrFail($this->data->transactionId);

        DB::transaction(function () use ($transaction) {
            if(Transaction::TYPE_SELL === $transaction->type)
                $newBalance = bcadd($transaction->wallet->balance, $transaction->amount, 8);
            else
                $newBalance = bcsub($transaction->wallet->balance, $transaction->amount, 8);

            $transaction->wallet->update(['balance' => $newBalance]);
            $transaction->delete();
        });
    }
}
