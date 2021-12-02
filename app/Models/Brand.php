<?php

namespace App\Models;

use App\Traits\GlobalScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory,GlobalScopes;

    protected $fillable = [
       'name', 'slug' ,'logo',
       'meta', 'visible'
    ];


    public function getLogoAttribute($value)
    {
        return asset('uploads/brands/'.$value);
    }
}
