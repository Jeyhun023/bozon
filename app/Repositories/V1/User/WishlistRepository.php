<?php


namespace App\Repositories\V1\User;


use App\Models\Product;
use App\Models\Wishlist;
use App\Repositories\V1\Contracts\WishlistRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;

class WishlistRepository implements WishlistRepositoryInterface
{
    use ApiResponder;

    public function getWishlists()
    {
      $this->data = auth()->user()->wishlist;
      return $this->returnData();
    }

    public function addWishlist($productId)
    {
        $product = Product::findOrFail($productId);
        $user = auth()->user();
        $status = Wishlist::where('user_id',$user->id)
            ->where('product_id',$product->id)
            ->first();

        if(isset($status->user_id)) {
            $this->message = 'This item is already in your wishlist!';
            $this->status = JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
        } else {
            $wishlist = new Wishlist;
            $wishlist->product_id = $product->id;
            $user->wishlist()->save($wishlist);
            $wishlist->load('product','product.images');
            $this->data = $wishlist;
        }

        return $this->returnData();
    }

    public function removeWishlist($productId)
    {
       Wishlist::where([
           'user_id' => auth()->user()->id,
           'product_id' => $productId
       ])->delete();

       $this->message = trans('messages.deleted');

       return $this->returnData();
    }
}
