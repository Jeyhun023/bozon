<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductColorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'color_id' => $this->color ? $this->color->id : '',
            'name' => $this->color ? $this->color->name : '',
            'code' => $this->color ? $this->color->code : '',
        ];
    }
}
