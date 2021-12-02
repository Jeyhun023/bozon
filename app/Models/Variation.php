<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'color_id',
        'attribute_id',
        'variation',
        'sku',
        'price',
        'qty',
    ];

    public function color()
    {
        return $this->belongsTo(Color::class);
    }
}
