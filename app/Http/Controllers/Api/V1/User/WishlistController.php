<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\WishlistResource;
use App\Repositories\V1\Contracts\WishlistRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
  use  ApiResponder;

    /**
     * @var WishlistRepositoryInterface
     */
    private $wishlistRepository;

    /**
     * WishlistController constructor.
     * @param WishlistRepositoryInterface $wishlistRepository
     */
    public function __construct(WishlistRepositoryInterface $wishlistRepository)
    {
        $this->wishlistRepository = $wishlistRepository;
    }

    public function getWishlists()
    {
        $result = $this->wishlistRepository->getWishlists();
        return $this->sendResourceResponse($result,WishlistResource::class);
    }

    public function addWishlist($productId)
    {
        $result = $this->wishlistRepository->addWishlist($productId);
        return $this->sendResourceResponse($result,WishlistResource::class,false);
    }

    public function removeWishlist($productId)
    {
        $this->wishlistRepository->removeWishlist($productId);
        $result = $this->wishlistRepository->getWishlists();
        return $this->sendResourceResponse($result,WishlistResource::class);
    }
}
