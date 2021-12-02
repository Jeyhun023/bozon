<?php


namespace App\QueryFilters;


class Position extends Filter
{

    protected function applyFilters($builder)
    {
        $name = request($this->filterName());
        if ($name) {
            return $builder->where('position', 'like', '%' . $name. '%');
        }

        return $builder;
    }
}
