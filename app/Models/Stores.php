<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    use HasFactory;

    protected $table = 'stores';
    protected $guarded = ['id'];

    public function userdetail()
    {
        return $this->hasMany(User::class, 'seller_id', 'id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function rating()
    {
        return $this->hasMany(Rating::class,'seller_id','id')->selectRaw('avg(seller_rate) as aggregate, seller_id')->groupBy('seller_id');
    }

    public function rates()
    {
        return $this->hasMany(Rating::class,'seller_id','id');
    }
}
