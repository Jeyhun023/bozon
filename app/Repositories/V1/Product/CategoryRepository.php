<?php


namespace App\Repositories\V1\Product;


use App\Models\Category;
use App\Repositories\V1\Contracts\CategoryRepositoryInterface;
use App\Traits\ApiResponder;

class CategoryRepository implements CategoryRepositoryInterface
{
    use ApiResponder;

    /**
     * @return array
     */
    public function index(): array
    {
        $categories = Category::select('id','parent_id','name','banner','slug')
            ->selectRaw('( SELECT COUNT(*) FROM `products` WHERE products.category_id IN (SELECT C.id from categories as C WHERE C.parent_id = categories.id) ) AS `product_count`')
            ->visible(true)->get();
        $this->data = buildCategoryTree($categories);
        return $this->returnData();
    }



    public function store(array $data)
    {
        // TODO: Implement store() method.
    }

    /**
     * @param int $id
     * @return array
     */
    public function show(int $id): array
    {
        $categories = Category::select('id','parent_id','name')
            ->selectRaw('( SELECT COUNT(*) FROM `products` WHERE products.category_id IN (SELECT C.id from categories as C WHERE C.parent_id = categories.id) ) AS `product_count`')
            ->visible(true)->with('children')->findOrFail($id);
        $this->data = $categories;
        return $this->returnData();
    }

    public function update(int $id, array $data)
    {
        // TODO: Implement update() method.
    }

    public function destroy(int $id)
    {
        // TODO: Implement destroy() method.
    }

    public function getCategoriesByStore(int $storeId)
    {
        $categories = Category::select('id','parent_id','name')
            ->visible(true)
            ->whereIn('id',function ($query) use ($storeId){
                $query->from('products')
                    ->select('products.category_id')
                    ->where('products.seller_id',$storeId)
                    ->groupBy('products.category_id');
            })->get();
        $this->data = $categories;
        return $this->returnData();
    }
}
