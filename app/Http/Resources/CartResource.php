<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
           'total' => (double)$this->total,
           'payable' => (double)$this->payable,
           'shipping_charges' => (double)$this->shipping_charges,
           'items' => $this->whenLoaded('items', function () {
               return CartItemResource::collection($this->items);
           }),
       ];
    }
}
