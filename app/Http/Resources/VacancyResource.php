<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VacancyResource extends JsonResource
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
            'position' => $this->position,
            'slug' => $this->slug,
            'email' => $this->email,
            'sort' => $this->sira,
            'deadline' => $this->dead_line->format('j-F-Y'),
            'about' => $this->about,
        ];
    }
}
