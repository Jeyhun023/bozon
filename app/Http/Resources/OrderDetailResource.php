<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
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
            $this->mergeWhen($this->relationLoaded('order'), [
                'orderId' => $this->order->id,
                'orderno' => $this->order->orderno
            ]),
            $this->mergeWhen($this->relationLoaded('productRate'), [
                'rate' =>  $this->productRate ? $this->productRate->product_rate : 0 ,
            ]),
            'attributes' => json_encode($this->attributes),
            'quantity' => $this->quantity,
            'price' => (float)$this->price,
            'status' => $this->whenLoaded('itemStatus', function () {
                return new OrderStatusResource($this->itemStatus);
            }),
            'product' => $this->whenLoaded('product', function () {
                return new ProductResource($this->product);
            }),
        ];
    }
}
