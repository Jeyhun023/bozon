<?php


namespace App\QueryFilters;


class Size extends Filter
{

    protected function applyFilters($builder)
    {
        $sizes = request($this->filterName());
        return $builder->whereHas('attributes', function ($query) {
            $query->where('attribute_id', 1);
        })->whereHas('attributes.variations', function ($query) use ($sizes) {
            $query->whereIn('name', (array) $sizes);
        });
    }
}
