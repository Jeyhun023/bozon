<?php


namespace App\QueryFilters;


class FullName extends Filter
{

    protected function applyFilters($builder)
    {
        $name = request($this->filterName());
        if ($name) {
            return $builder->where('full_name', 'like', '%' . $name . '%');
        }

        return $builder;
    }
}
