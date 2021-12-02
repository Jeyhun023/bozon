<?php


namespace App\Repositories\V1\Contracts;


interface FeatureRepositoryInterface extends CrudInterface
{
    public function FilterFeaturesForAdmin($category_id);

    public function getFeaturesByCategory($categoryId);
}
