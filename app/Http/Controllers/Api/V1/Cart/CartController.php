<?php

namespace App\Http\Controllers\Api\V1\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Product\CartRequest;
use App\Http\Resources\CartResource;
use App\Repositories\V1\Contracts\CartRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use ApiResponder;

    /**
     * @var CartRepositoryInterface
     */
    private $cartRepository;


    /**
     * CartController constructor.
     * @param CartRepositoryInterface $cartRepository
     */
    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCart()
    {
        $result = $this->cartRepository->getCart();
        return $this->sendResourceResponse($result,CartResource::class,false);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CartRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CartRequest $request)
    {
        $result = $this->cartRepository->store($request->all());
        return $this->sendResourceResponse($result,CartResource::class,false);
    }

    /**
     * @param CartRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProductCount(CartRequest $request)
    {
        $updateResult = $this->cartRepository->updateProductCount($request->all());
        if ($updateResult['code'] == JsonResponse::HTTP_NOT_FOUND){
            $result = $updateResult;
        } else {
            $result = $this->cartRepository->getCart();
        }
        return $this->sendResourceResponse($result,CartResource::class,false);
    }

    /**
     * @param $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeProduct($productId)
    {
        $this->cartRepository->removeProduct($productId);
        $result = $this->cartRepository->getCart();
        return $this->sendResourceResponse($result,CartResource::class,false);
    }

    public function removeCart()
    {
        $result = $this->cartRepository->removeCart();
        return $this->sendResponse($result);
    }
}
