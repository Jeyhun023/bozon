<?php


namespace App\QueryFilters;


class Feature extends Filter
{

    protected function applyFilters($builder)
    {
        return $builder->where('featured',request($this->filterName()));
    }
}
