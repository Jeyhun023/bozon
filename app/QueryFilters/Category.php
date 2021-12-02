<?php


namespace App\QueryFilters;
use App\Models\Category as CategoryModel;

class Category extends Filter
{
    protected function applyFilters($builder)
    {
        $categoryId = (array)request($this->filterName());
        $categories = CategoryModel::whereIn('parent_id', (array)$categoryId)->get()->pluck('id')->toArray();
        $categoryId = array_merge($categoryId, $categories);

        return $builder->whereIn('category_id',(array)$categoryId);
    }
}
