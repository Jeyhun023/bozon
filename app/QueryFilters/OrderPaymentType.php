<?php


namespace App\QueryFilters;


class OrderPaymentType extends Filter
{

    protected function applyFilters($builder)
    {
        $paymentType = request($this->filterName());
        if ($paymentType) {
            return $builder->where('payment_type', $paymentType);
        }

        return $builder;
    }
}
