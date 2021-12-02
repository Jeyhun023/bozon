<?php


namespace App\QueryFilters;


class DailyOpportunity extends Filter
{

    protected function applyFilters($builder)
    {
        return $builder->where('daily_opportunity',request($this->filterName()));
    }
}
