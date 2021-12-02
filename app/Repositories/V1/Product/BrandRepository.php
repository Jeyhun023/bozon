<?php


namespace App\Repositories\V1\Product;


use App\Models\Brand;
use App\Repositories\V1\Contracts\BrandRepositoryInterface;
use App\Traits\ApiResponder;

class BrandRepository implements BrandRepositoryInterface
{
    use ApiResponder;

    public function index()
    {
        $brands = Brand::visible(true)->get();
        $this->data = $brands;
        return $this->returnData();
    }

    public function store(array $data)
    {
        // TODO: Implement store() method.
    }

    public function show(int $id)
    {
        // TODO: Implement show() method.
    }

    public function update(int $id, array $data)
    {
        // TODO: Implement update() method.
    }

    public function destroy(int $id)
    {
        // TODO: Implement destroy() method.
    }
}
