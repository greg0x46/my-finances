<?php

namespace App\Data;

class CreateWalletData extends BaseData
{
    protected string $name;
    protected string $initialBalance;
    protected int $currencyId;

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'initialBalance' => ['numeric'],
            'currencyId' => ['integer', 'exists:currencies,id'],
        ];
    }
}
