<?php


namespace App\Repositories\V1\Contracts;


interface CartRepositoryInterface
{
    public function getCart();

    public function store(array $data);

    public function updateProductCount(array $data);

    public function removeProduct(int $itemId);

    public function removeCart();
}
