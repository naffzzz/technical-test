<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'event_date',
        'is_open',
        'status',
        'open_order_status',
        'creator_id',
        'image',
        'sell',
        'return',
        'type',
        'description'
    ];
}
