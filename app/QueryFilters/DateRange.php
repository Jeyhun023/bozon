<?php


namespace App\QueryFilters;


class DateRange extends Filter
{

    protected function applyFilters($builder)
    {
        $dateRange = request($this->filterName());
        if ($dateRange) {
            $dateRange = explode('-',request($this->filterName()));
            $from = isset($dateRange[0]) ? date("Y-m-d",strtotime($dateRange[0])) : null;
            $to = isset($dateRange[1]) ?  date("Y-m-d",strtotime($dateRange[1])) : now();
            return $builder->whereBetween('created_at', [$from, $to]);
        }

        return $builder;
    }
}
