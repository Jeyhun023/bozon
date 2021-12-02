<?php

namespace App\Models;

use App\Traits\GlobalScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes, GlobalScopes;

    protected $fillable = [
        'parent_id', 'visible', 'name',
        'banner', 'slug', 'sort', 'meta_title', 'meta_desc'
    ];

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->with(['children']);
    }

    public function children2()
    {
        return $this->hasMany(self::class, 'parent_id')->with(['children' => function ($query) {
            $query->select('id', 'parent_id', 'name');
        }]);
    }

    public function getBannerAttribute($value)
    {
        return !is_null($value) ? asset('uploads/categories/' . $value) : null;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
