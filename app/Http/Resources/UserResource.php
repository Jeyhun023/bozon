<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'customer_code' => $this->customer_code,
            'full_name' => $this->full_name,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'photo' => $this->photo,
            'rating' => $this->whenLoaded('rating', function () {
                return $this->rating->isNotEmpty() ? round($this->rating[0]->aggregate) : 0;
            }),
        ];
    }
}
