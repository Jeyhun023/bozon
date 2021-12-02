<?php


namespace App\QueryFilters;


class OrderType extends Filter
{

    protected function applyFilters($builder)
    {
        $type = request($this->filterName());
        if ($type) {
            return $builder->where('order_type', $type);
        }

        return $builder;
    }
}
