<?php


namespace App\QueryFilters;


class MostSale extends Filter
{

    protected function applyFilters($builder)
    {
        return $builder->orderBy('sale_count','desc');
    }
}
