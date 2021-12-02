<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Http\Resources\UserResource;
use App\Repositories\V1\Contracts\StoreRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    use ApiResponder;

    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepository;

    public function __construct(StoreRepositoryInterface $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    public function index()
    {
        $result = $this->storeRepository->getAllStores();
        return $this->sendResourceResponse($result,StoreResource::class);
    }


    public function getStoreById($storeId)
    {
        $result = $this->storeRepository->getStoreById($storeId);
        return $this->sendResourceResponse($result,StoreResource::class,false);
    }

}
