<?php


namespace App\QueryFilters;


use Carbon\Carbon;

class IsNew extends Filter
{

    protected function applyFilters($builder)
    {
        return $builder->where("created_at",">",Carbon::now()->subDay(7))->where("created_at","<",Carbon::now());
    }
}
