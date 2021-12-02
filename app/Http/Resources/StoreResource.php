<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
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
            'full_name' => $this->full_name,
            'about' => $this->about,
            'url' => $this->url,
            'rating' => $this->whenLoaded('rating', function () {
                return $this->rating->isNotEmpty() ? round($this->rating[0]->aggregate) : 0;
            }),
            'banner_image' => asset('uploads/magazas/'.$this->thumb_nail),
            'logo' => asset('uploads/magazas/'.$this->logo),
            'rateCount' => $this->rates_count ? $this->rates_count : 0,
            'category' => $this->whenLoaded('category', function () {
                return $this->category ? $this->category->name : null;
            }),
        ];
    }
}
