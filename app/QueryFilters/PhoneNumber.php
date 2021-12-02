<?php


namespace App\QueryFilters;


class PhoneNumber extends Filter
{

    protected function applyFilters($builder)
    {
        $name = request($this->filterName());
        if ($name) {
            return $builder->where('phone_number', 'like', '%' . $name . '%');
        }

        return $builder;
    }
}
