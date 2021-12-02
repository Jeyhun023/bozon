<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'order_id', 'product_id', 'stock',
      'status', 'price', 'discount',
      'quantity', 'attributes','seller_id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function itemStatus()
    {
        return $this->belongsTo(OrderStatus::class,'status','id');
    }

    public function productRate()
    {
        return $this->belongsTo(Rating::class, 'product_id', 'product_id')
            ->where('user_id', auth('api')->check() ? auth()->user()->id : 0);
    }

    public function kuryer_detail()
    {
        return $this->belongsTo(User::class, 'kuryer_id', 'id');
    }

    public function parentStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'status');
    }

    public function store_detail()
    {
        return $this->belongsTo(Stores::class, 'seller_id', 'id');
    }

    public function getAttributesAttribute($attributes)
    {
        return json_decode($attributes, true);
    }
}
