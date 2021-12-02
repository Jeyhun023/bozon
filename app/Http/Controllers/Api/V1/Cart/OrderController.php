<?php

namespace App\Http\Controllers\Api\V1\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Order\OrderRequest;
use App\Http\Requests\Api\V1\Order\PayDirectlyRequest;
use App\Http\Resources\OrderDetailResource;
use App\Http\Resources\OrderResource;
use App\Models\OrderDetail;
use App\Repositories\V1\Contracts\CartRepositoryInterface;
use App\Repositories\V1\Contracts\OrderRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ApiResponder;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;
    /**
     * @var CartRepositoryInterface
     */
    private $cartRepository;

    public function __construct(OrderRepositoryInterface $orderRepository, CartRepositoryInterface $cartRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->cartRepository = $cartRepository;
    }

    public function getOrders()
    {
        $result = $this->orderRepository->getOrdersByUser();
        return $this->sendResourceResponse($result,OrderResource::class);
    }

    public function getOrderItemsByOrderNumber($orderNumber)
    {
        $result = $this->orderRepository->getOrderItemsByOrderNumber($orderNumber);
        return $this->sendResourceResponse($result,OrderDetailResource::class);
    }

    public function getOrderItems($orderId)
    {
        $result = $this->orderRepository->getOrderItemsByOrder($orderId);
        return $this->sendResourceResponse($result,OrderDetailResource::class);
    }

    public function getOrderItemsByUser()
    {
        $result = $this->orderRepository->getOrderItemsByUser();
        return $this->sendResourceResponse($result,OrderDetailResource::class);
    }

    public function makeOrder(OrderRequest $request)
    {
        $cartResult = $this->cartRepository->getCart();
        $result = $this->orderRepository->makeOrder($request->all(),$cartResult);
        return $this->sendResponse($result);
    }

    public function payDirectly(PayDirectlyRequest $request,$productId)
    {
        $result = $this->orderRepository->payDirectly($request->all(),$productId);
        return $this->sendResponse($result);
    }
}
