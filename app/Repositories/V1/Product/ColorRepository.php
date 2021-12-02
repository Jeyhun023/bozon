<?php


namespace App\Repositories\V1\Product;


use App\Models\Color;
use App\Repositories\V1\Contracts\ColorRepositoryInterface;
use App\Traits\ApiResponder;

class ColorRepository implements ColorRepositoryInterface
{
    use ApiResponder;

    public function getAllColors()
    {
       $colors = Color::select('id','name','code')->get();
       $this->data = $colors;
       return $this->returnData();
    }
}
