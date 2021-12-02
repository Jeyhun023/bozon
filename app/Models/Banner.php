<?php

namespace App\Models;

use App\Traits\GlobalScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory, GlobalScopes;

    protected $fillable = [
        'title', 'thumb_image', 'main_image', 'url', 'visible', 'sira'
    ];

    public function getThumbImageAttribute($value)
    {
        return asset('uploads/banners/' . $value);
    }

    public function getMainImageAttribute($value)
    {
        return asset('uploads/banners/' . $value);
    }
}
