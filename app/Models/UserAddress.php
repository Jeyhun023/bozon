<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $with = [
        'city'
    ];

    protected $fillable = [
        'user_id','title','is_default',
        'address','full_address','phone_number',
        'user_name','lat','lng','city_id','zip_code'
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
