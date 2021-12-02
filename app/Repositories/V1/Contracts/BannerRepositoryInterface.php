<?php


namespace App\Repositories\V1\Contracts;


interface BannerRepositoryInterface extends CrudInterface
{
    public function getAllBanners();
}
