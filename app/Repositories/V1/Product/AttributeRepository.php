<?php


namespace App\Repositories\V1\Product;


use App\Models\Attribute;
use App\Repositories\V1\Contracts\AttributeRepositoryInterface;
use App\Traits\ApiResponder;

class AttributeRepository implements AttributeRepositoryInterface
{
    use ApiResponder;

    public function index()
    {
       $attributes = Attribute::all();
       $this->data = $attributes;

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
