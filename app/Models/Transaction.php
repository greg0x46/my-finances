<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    protected $fillable = [
      'wallet_id',
      'type',
      'amount',
      'unit_price',
      'total_price',
      'date'
    ];
}
