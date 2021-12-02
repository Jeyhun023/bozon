<?php


namespace App\QueryFilters;


class Visible extends Filter
{

    protected function applyFilters($builder)
    {
        return $builder->visible(request($this->filterName()));
    }
}
