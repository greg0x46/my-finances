<?php

namespace App\UseCases;

use App\Data\CreateTransactionData;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Traits\MakeableTrait;
use Illuminate\Support\Facades\DB;

class CreateTransaction
{
    use MakeableTrait;

    protected CreateTransactionData $data;

    public function __construct(CreateTransactionData $data)
    {
        $this->data = $data;
    }

    public function execute(): Transaction
    {
        $wallet = Wallet::findOrFail($this->data->walletId);
        $newBalance = match ($this->data->type) {
            Transaction::TYPE_BUY => bcadd($wallet->balance, $this->data->amount, 8),
            Transaction::TYPE_SELL => bcsub($wallet->balance, $this->data->amount, 8),
            default => $wallet->balance,
        };

        $transaction = DB::transaction(function () use ($wallet, $newBalance) {
            $wallet->update(['balance' => $newBalance]);

            return Transaction::create([
                'wallet_id' => $this->data->walletId,
                'type' => $this->data->type,
                'amount' => $this->data->amount,
                'unit_price' => $this->data->unitPrice,
                'total_price' => bcmul($this->data->amount, $this->data->unitPrice, 8),
                'date' => $this->data->date,
            ]);
        });

        return $transaction;
    }
}
