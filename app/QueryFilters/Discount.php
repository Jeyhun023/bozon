<?php


namespace App\QueryFilters;


class Discount extends Filter
{

    protected function applyFilters($builder)
    {
        return  $builder->where(function ($query) {
            $query->where('discount_price', '!=', 0)->whereNotNull('discount_price');
        });
    }
}
