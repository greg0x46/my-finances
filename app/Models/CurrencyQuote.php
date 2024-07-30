<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyQuote extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency_id',
        'quote_currency_id',
        'price',
        'price_at',
    ];
}
