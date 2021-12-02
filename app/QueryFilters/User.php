<?php


namespace App\QueryFilters;


class User extends Filter
{

    protected function applyFilters($builder)
    {
        $user = request($this->filterName());
        if ($user) {
            return $builder->whereHas('user', function ($query) use ($user) {
                if (isset($user['id'])) {
                    if ($user['id']) {
                        $query->where('id', $user['id']);
                    }
                }
                if (isset($user['name'])) {
                    if ($user['name']) {
                        $query->where('full_name', 'like', '%' . $user['name'] . '%');
                    }
                }
                if (isset($user['email'])) {
                    if ($user['email']) {
                        $query->where('email', 'like', '%' . $user['email'] . '%');
                    }
                }
                if (isset($user['phone'])) {
                    if ($user['phone']) {
                        $query->where('phone_number', 'like', '%' . $user['phone'] . '%');
                    }
                }
                return $query;
            });
        }

        return $builder;
    }
}
