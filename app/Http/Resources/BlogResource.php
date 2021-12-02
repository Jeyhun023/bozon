<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
          'title' => $this->title,
          'slug' => $this->slug,
          'url' => $this->url,
          'description' => $this->description,
          'thumb_nail' => asset('uploads/blogs/'.$this->thumb_nail),
          'create_at' => $this->created_at->format('j-F-Y'),
        ];
    }
}
