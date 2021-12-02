<?php

namespace App\Http\Controllers\Api\V1\Cart;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Repositories\V1\Contracts\CityRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class CityController extends Controller
{

    use ApiResponder;

    /**
     * @var CityRepositoryInterface
     */
    private $cityRepository;

    public function __construct(CityRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function index()
    {
        $result = $this->cityRepository->index();
        return $this->sendResourceResponse($result,CityResource::class);
    }
}
