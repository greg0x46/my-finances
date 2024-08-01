<?php

namespace App\Data;

use Carbon\Carbon;

class CreateTransactionData extends BaseData
{
    protected int $walletId;
    protected string $type;
    protected string $amount;
    protected string $unitPrice;
    protected Carbon $date;

    protected function setDate($date)
    {
        $this->date = Carbon::parse($date);
    }

    public function rules(): array
    {
        return [
            'walletId' => ['required', 'integer', 'exists:wallets,id'],
            'type' => ['required', 'string', 'in:buy,sell'],
            'amount' => ['required', 'numeric', 'min:0.000000001'],
            'unitPrice' => ['required', 'numeric', 'min:0.000000001'],
            'date' => ['required', 'date', 'date_format:Y-m-d H:i:s'],
        ];
    }
}
