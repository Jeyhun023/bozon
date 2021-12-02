<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'orderno' => $this->orderno,
            'product_count' => $this->items_count,
            'payment_type' => $this->payment_type,
            'address' => $this->address,
            'price' => (float)$this->payed,
            'created_at' => $this->created_at->format('d.m.y H:i'),
        ];
    }
}
