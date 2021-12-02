<?php

namespace App\Models;

use App\Traits\GlobalScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes,GlobalScopes;

    protected $fillable = [
        'seller_id', 'category_id', 'visible',
        'name', 'description', 'price','featured',
        'discount_type', 'discount_price','thumbnail',
        'slug','meta','qty', 'daily_opportunity','sale_count'
    ];

    public function images()
    {
        return $this->morphMany(File::class,'model');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function rating()
    {
        return $this->hasMany(Rating::class,'product_id','id')->selectRaw('avg(product_rate) as aggregate, product_id')->groupBy('product_id');
    }

    public function rates()
    {
        return $this->hasMany(Rating::class,'product_id','id');
    }

    public function seller()
    {
        return $this->belongsTo(Stores::class,'seller_id');
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function colors()
    {
        return $this->hasMany(ProductColor::class)->with(['color']);
    }

    public function features()
    {
        return $this->hasMany(ProductFeature::class,'product_id');
    }

    public function variations()
    {
        return $this->hasMany(Variation::class,'product_id');
    }
}
