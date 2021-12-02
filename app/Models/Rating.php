<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','seller_id','product_id',
        'status','product_rate','seller_rate',
        'note','order_id'
    ];

    public function seller()
    {
        return $this->belongsTo(User::class,'seller_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
