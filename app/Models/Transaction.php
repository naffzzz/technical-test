<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'buyer_id',
        'is_paid',
        'qr_code_token',
        'payment_method',
        'payment_account_id'
    ];
}
