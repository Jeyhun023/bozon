<?php


namespace App\QueryFilters;


class Title extends Filter
{

    protected function applyFilters($builder)
    {
        $title = request($this->filterName());
        if ($title) {
            return $builder->where('title', 'like', '%' . $title. '%');
        }

        return $builder;
    }
}
