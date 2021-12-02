<?php


namespace App\Repositories\V1\Contracts;


interface StoreRepositoryInterface
{
    public function getAllStores();

    public function getStoreById(int $storeId);
}
