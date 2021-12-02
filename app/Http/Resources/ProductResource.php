<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $productDateDiff = $this->created_at->diffInWeeks(now());
        return [
            'id' => $this->id,
            'seller_id' => $this->seller_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'thumbnail' => asset('uploads/products/thumbnails/'.$this->thumbnail),
            'meta' => $this->meta,
            'description' => $this->description,
            'price' => (double)$this->price,
            'discount_type' => $this->discount_type,
            'discount_price' => (double)$this->discount_price,
            'featured' => $this->featured,
            'daily_opportunity' => $this->daily_opportunity,
            'is_new' => $productDateDiff < 1 ? true: false,
            'colors' => $this->whenLoaded('colors', function () {
                return ProductColorResource::collection($this->colors);
            }),
            'rating' => $this->whenLoaded('rating', function () {
                return $this->rating->isNotEmpty() ? round($this->rating[0]->aggregate) : 0;
            }),
            'rateCount' => $this->rates_count ? $this->rates_count : 0,
            'category' => $this->whenLoaded('category', function () {
                return new CategoryResource($this->category);
            }),
            'brand' => $this->whenLoaded('brand', function () {
                return new BrandResource($this->brand);
            }),
            'seller' => $this->whenLoaded('seller', function () {
                return new StoreResource($this->seller);
            }),
            'images' => $this->whenLoaded('images', function () {
                return FileResource::collection($this->images);
            }),
            'related' => $this->when(
                $this->relationLoaded('category') &&
                $this->category->relationLoaded('products'),
                function () {
                    return ProductResource::collection($this->category->products);
                }
            ),
            'attributes' => $this->whenLoaded('attributes', function () {
                return ProductAttributeResource::collection($this->attributes);
            }),
        ];
    }
}
