<?php


namespace App\QueryFilters;


class OrderNumber extends Filter
{

    protected function applyFilters($builder)
    {
        $orderNumber = request($this->filterName());
        if ($orderNumber) {
            return $builder->where('orderno', $orderNumber);
        }

        return $builder;
    }
}
