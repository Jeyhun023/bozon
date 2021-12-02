<?php


namespace App\QueryFilters;


class Name extends Filter
{

    protected function applyFilters($builder)
    {
        $name = request($this->filterName());
        if ($name) {
            return $builder->where('name', 'like', '%' . $name. '%');
        }

        return $builder;
    }
}
