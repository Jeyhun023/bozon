<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $table = 'payments';
    protected $fillable = [
        'user_id',
        'order_id',
        'session_id',
        'currency',
        'amount',
        'detail',
        'status_code',
        'order_status',
        'order_description',
        'order_check_status',
    ];

}
