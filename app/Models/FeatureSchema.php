<?php

namespace App\Models;

use App\Traits\GlobalScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeatureSchema extends Model
{
    use HasFactory,GlobalScopes;

    protected $fillable = [
        'category_id','visible',
        'name','sort'
    ];

    public function values()
    {
        return $this->hasMany(FeatureSchemaValue::class, 'schema_id','id');
    }
}
