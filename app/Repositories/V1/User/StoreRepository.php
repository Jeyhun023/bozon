<?php


namespace App\Repositories\V1\User;


use App\Models\Stores;
use App\Models\User;
use App\Repositories\V1\Contracts\StoreRepositoryInterface;
use App\Traits\ApiResponder;

class StoreRepository implements StoreRepositoryInterface
{
    use ApiResponder;

    public function getAllStores(): array
    {
        $sellers = Stores::with('category','rating')->where('active',1)->paginate(8);
        $this->data = $sellers;
        return $this->returnData();
    }

    public function getStoreById(int $storeId)
    {
        $sellers = Stores::with('category','rating')
            ->withCount('rates')
            ->where('active',1)
            ->findOrFail($storeId);
        $this->data = $sellers;
        return $this->returnData();
    }
}
