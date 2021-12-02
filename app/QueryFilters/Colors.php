<?php


namespace App\QueryFilters;


class Colors extends Filter
{

    protected function applyFilters($builder)
    {
        $colors = request($this->filterName());
        return $builder->whereHas('colors', function ($query) use ($colors) {
            $query->whereIn('color_id', (array) $colors);
        });
    }
}
