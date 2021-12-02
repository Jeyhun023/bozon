<?php


namespace App\QueryFilters;


class Product extends Filter
{

    protected function applyFilters($builder)
    {
        return $builder->where('product_id',request($this->filterName()));
    }
}
