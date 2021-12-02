<?php


namespace App\Repositories\V1\Contracts;


interface CategoryRepositoryInterface extends CrudInterface
{
    public function getCategoriesByStore(int $storeId);
}
