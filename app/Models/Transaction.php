<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    const TYPE_BUY = 'buy';
    const TYPE_SELL = 'sell';

    protected $fillable = [
        'wallet_id',
        'type',
        'amount',
        'unit_price',
        'total_price',
        'date'
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
