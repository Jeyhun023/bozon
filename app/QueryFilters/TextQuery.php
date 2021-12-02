<?php


namespace App\QueryFilters;


class TextQuery extends Filter
{

    protected function applyFilters($builder)
    {
        $searchText =  request($this->filterName());

        return  $builder->where(function ($query) use($searchText){
            $query->where('name', 'like', "%{$searchText}%");
            $query->orWhere('description', 'like', "%{$searchText}%");
        });
    }
}
