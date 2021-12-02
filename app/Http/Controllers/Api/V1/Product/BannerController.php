<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Repositories\V1\Contracts\BannerRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    use ApiResponder;

    /**
     * @var BannerRepositoryInterface
     */
    private $bannerRepository;

    public function __construct(BannerRepositoryInterface $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    public function getAllBanners()
    {
        $result = $this->bannerRepository->getAllBanners();
        return  $this->sendResourceResponse($result,BannerResource::class);
    }
}
