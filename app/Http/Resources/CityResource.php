<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $options = null;
        if ($this->relationLoaded('children')){
            if ($this->children->isNotEmpty()){
                $options = CityResource::collection($this->children);
            }
        }
        $responseData = [
            'value' => $this->id,
            'label' => $this->name,
            'delivery' => $this->deliver_price == 0 ? 'Pulsuz' : $this->deliver_price,
        ];
        if (!is_null($options)){
            $responseData['options'] = $options;
        }
        return $responseData;
    }
}
