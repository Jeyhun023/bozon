<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'product_count' => $this->product_count,
            'name' => $this->name,
            'slug' => $this->slug,
            'banner' => $this->banner,
            'children' => $this->children,
        ];
    }
}
