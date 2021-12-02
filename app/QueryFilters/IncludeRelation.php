<?php


namespace App\QueryFilters;


class IncludeRelation extends Filter
{

    protected function applyFilters($builder)
    {
        $relations = explode(',',request($this->filterName()));
       return $builder->with($relations);
    }
}
