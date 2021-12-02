<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'title' => $this->title,
            'is_default' => $this->is_default,
            'address' => $this->address,
            'zip_code' => $this->zip_code,
            'full_address' => $this->full_address,
            'phone_number' => $this->phone_number,
            'user_name' => $this->user_name,
            'city' => $this->whenLoaded('city', function () {
                return new CityResource($this->city);
            }),
            'lat' => $this->lat,
            'lng' => $this->lng,
        ];
    }
}
