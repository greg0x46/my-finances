<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CDI extends Model
{
    use HasFactory;

    protected $table = 'cdi';

    protected $fillable = ['day', 'value'];
}
