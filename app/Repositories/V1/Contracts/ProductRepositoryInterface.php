<?php


namespace App\Repositories\V1\Contracts;


interface ProductRepositoryInterface extends CrudInterface
{
    public function getVariations();

    public function getProductsByStore();

    public function getCatalogs();

    public function copyProductFromCatalog($data);
}
