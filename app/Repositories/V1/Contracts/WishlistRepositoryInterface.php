<?php


namespace App\Repositories\V1\Contracts;


interface WishlistRepositoryInterface
{
    public function getWishlists();

    public function addWishlist($productId);

    public function removeWishlist($productId);
}
