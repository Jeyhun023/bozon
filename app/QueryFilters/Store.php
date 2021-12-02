<?php


namespace App\QueryFilters;


class Store extends Filter
{

    protected function applyFilters($builder)
    {
        return $builder->where('seller_id',request($this->filterName()));
    }
}
