<?php


namespace App\Repositories\V1\Contracts;


interface OrderRepositoryInterface
{
    public function makeOrder($data,$cartData);

    public function payDirectly($data,$productId);

    public function getOrdersByUser();

    public function getOrderItemsByOrderNumber($orderNumber);

    public function getOrderItemsByOrder(int $orderId);

    public function getOrderItemsByUser();
}
