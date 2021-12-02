<?php


namespace App\QueryFilters;


class Price extends Filter
{

    protected function applyFilters($builder)
    {
        $price = request($this->filterName());

        if(isset($price['min'])) {
            $this->searchMinPrice($builder,$price['min']);
        }
        if(isset($price['max'])) {
            $this->searchMaxPrice($builder,$price['max']);
        }
        return $builder;
    }

    private function searchMinPrice($builder,$price)
    {
        $builder->where('price','>=',$price);
    }

    private function searchMaxPrice($builder,$price)
    {
        $builder->where('price','<=',$price);
    }
}
