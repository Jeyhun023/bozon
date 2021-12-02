<?php


namespace App\QueryFilters;


class OrderSellerStatus extends Filter
{

    protected function applyFilters($builder)
    {
        $orderStatus = request($this->filterName());
        if (request()->has('order_status')) {
//            if ($orderStatus) {
                return $builder->whereHas('detail', function ($query) use ($orderStatus) {
                    $query->where('seller_status', $orderStatus);
                });
//            }
        }

        return $builder;
    }
}
