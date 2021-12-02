<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeatureSchemaValue extends Model
{
    use HasFactory;
    protected $fillable = ['schema_id', 'name'];

    public function schema()
    {
        return $this->belongsTo(FeatureSchema::class, 'schema_id', 'id');
    }
}
