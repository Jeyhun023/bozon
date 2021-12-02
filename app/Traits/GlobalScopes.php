<?php


namespace App\Traits;


trait GlobalScopes
{
    /**
     * @param $query
     * @param bool $visible
     * @return mixed
     */
    public function scopeVisible($query,$visible = true)
    {
        return $query->where('visible',$visible);
    }
}
