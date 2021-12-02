<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductAttributeResource extends JsonResource
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
            'name' => $this->attribute ? $this->attribute->name : '',
            'variations' => $this->whenLoaded('variations', function () {
                return ProductAttributeVariationResource::collection($this->variations);
            }),
        ];
    }
}
