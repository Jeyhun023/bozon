<?php


namespace App\Repositories\V1\Product;


use App\Models\Product;
use App\Models\Rating;
use App\Repositories\V1\Contracts\RatingRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Pipeline\Pipeline;

class RatingRepository implements RatingRepositoryInterface
{
    use ApiResponder;

    public function index()
    {
        $rating = app(Pipeline::class)
            ->send(Rating::query()->with('user')->where('status',2))
            ->through([
                \App\QueryFilters\Product::class,
                \App\QueryFilters\Store::class,
            ])
            ->thenReturn()
            ->paginate(5);
        $this->data = $rating;
        return $this->returnData();
    }

    public function store(array $data)
    {
        $product = Product::select('seller_id')->findOrFail($data['product_id']);
        $data['user_id'] = auth()->user()->id;
        $data['seller_id'] = $product->seller_id;
        $data['status'] = 0;
       $rating = new Rating;
       $rating->fill($data);
       $rating->save();
       $rating->load(['seller','product']);
       $this->data = $rating;
       return $this->returnData();
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
