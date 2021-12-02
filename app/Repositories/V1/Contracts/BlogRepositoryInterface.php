<?php


namespace App\Repositories\V1\Contracts;


interface BlogRepositoryInterface extends CrudInterface
{
    public function getActiveBlogs();

    public function show($slug);
}
