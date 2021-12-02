<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
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
            'id' => (int)$this->id,
            'product_rate' => (int)$this->product_rate,
            'seller_rate' => (int)$this->seller_rate,
            'note' => $this->note,
            'status' => $this->status,
            'created_at' => $this->created_at->format('d.m.Y h:i'),
            'seller' => $this->whenLoaded('seller', function () {
                return new UserResource($this->seller);
            }),
            'product' => $this->whenLoaded('product', function () {
                return new ProductResource($this->product);
            }),
            'user' => $this->whenLoaded('user', function () {
                return new UserResource($this->user);
            }),
        ];
    }
}
