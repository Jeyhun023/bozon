<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeVariation extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_attribute_id',
        'name',
    ];
}
