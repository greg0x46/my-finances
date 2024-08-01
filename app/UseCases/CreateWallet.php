<?php

namespace App\UseCases;

use App\Models\Wallet;
use App\Traits\MakeableTrait;
use App\Data\CreateWalletData;

class CreateWallet
{
    use MakeableTrait;

    protected CreateWalletData $data;

    public function __construct(CreateWalletData $data)
    {
        $this->data = $data;
    }

    public function execute(): Wallet
    {
        return Wallet::create([
            'name' => $this->data->name,
            'currency_id' => $this->data->currencyId,
            'initial_balance' => $this->data->initialBalance,
            'balance' => $this->data->initialBalance,
        ]);
    }
}
