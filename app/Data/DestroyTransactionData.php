<?php

namespace App\Data;

class DestroyTransactionData extends BaseData
{
    protected int $transactionId;

    public function rules(): array
    {
        return ['transactionId' => ['required', 'integer', 'exists:transactions,id']];
    }
}
