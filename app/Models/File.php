<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_type','model_id','main','name'
    ];

    public function getNameAttribute($value)
    {
        switch ($this->model_type) {
            case 'App\Models\Product':
                return asset('uploads/products/'.$value);
                break;
        }
    }
}
