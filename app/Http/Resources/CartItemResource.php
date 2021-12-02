<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'price' => $this->product ?  (double)$this->product->price : 0,
            'discount_type' =>  $this->product ? $this->product->discount_type : null,
            'price_with_discount' => $this->product ? (double)$this->product->discount_price : 0,
            'attributes' => !is_null($this->attributes) ? $this->attributes : null,
            'product' => $this->whenLoaded('product', function () {
                return new ProductResource($this->product);
            }),
        ];
    }
}
