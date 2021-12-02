<?php


if (!function_exists('str_slug')) {
    function str_slug($title, $separator = '-', $language = 'en'){
        return \Illuminate\Support\Str::slug($title, $separator, $language);
    }
}

if (!function_exists('buildCategoryTree')) {
    function buildCategoryTree($elements,$parentId =0): array
    {
        $branches = [];
        foreach ($elements as $element) {
            if ($element->parent_id == $parentId) {
                $children = buildCategoryTree($elements,$element->id);
                if ($children) {
                    $element->children = $children;
                } else {
                    $element->children = null;
                }
                $branches[] = $element;
            }
        }
        return $branches;
    }
}

if (!function_exists('getPaginationLimit')) {
    function getPaginationLimit($newLimit = null, $queryStringName = 'limit')
    {
        $defaultLimit = is_null($newLimit) ? config('admin.limit') : (int)$newLimit;
        return request()->has($queryStringName) ? (int)request($queryStringName) : $defaultLimit;
    }
}

if (!function_exists('randString')) {
    function randString($length) {
        $char = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $char = str_shuffle($char);
        for($i = 0, $rand = '', $l = strlen($char) - 1; $i < $length; $i ++) {
            $rand .= $char[mt_rand(0, $l)];
        }
        return $rand;
    }
}
