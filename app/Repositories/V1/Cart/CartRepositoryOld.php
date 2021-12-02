<?php


namespace App\Repositories\V1\Cart;


use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Repositories\V1\Contracts\CartRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;

class CartRepositoryOld implements CartRepositoryInterface
{
    use ApiResponder;

    public function getCart()
    {
        $user = auth()->user();
        $user->load('cart','cart.items','cart.items.product','cart.items.product.images');
        $this->data = $user->cart;
        return $this->returnData();
    }

    public function store(array $data)
    {
        $cart = Cart::firstOrNew(['user_id' => auth()->user()->id]);
        if (!CartItem::where(['cart_id' => $cart->id, 'product_id' => $data['product_id']])->exists()) {
            $product = Product::find($data['product_id']);
            $prices = $this->calculateCartPrices($cart,$product,$data['quantity']);
            $cart->total = $prices['total'];
            $cart->payable = $prices['payable'];
            $cart->save();

            $cartItem = new CartItem;
            $cartItem->product_id = $product->id;
            $cartItem->quantity = $data['quantity'];
            $cartItem->price = $product->price;
            $cartItem->discount_type = $product->discount_type;
            $cartItem->price_with_discount = $product->discount_price;
            $cart->items()->save($cartItem);
            $this->data = $cart;
            $this->message = trans('messages.created');
        } else {
            $this->status = JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
            $this->message = trans('messages.product_exists_cart');
        }

      return $this->returnData();
    }

    private function calculateCartPrices($cart,$product,$quantity): array
    {
        $productPrice =  ($product->price * $quantity);
        $productDiscountPrice = ($product->discount_price * $quantity);
        if (!is_null($cart)) {
            $items = $cart->items;
            $total = $items->sum(function ($item){
                return $item->quantity * $item->price;
            });
            $total = $total + $productPrice;
            $payable = $items->sum(function ($item){
                return $item->quantity * $item->price_with_discount;
            });
            $payable = $total - ($payable + $productDiscountPrice);
        } else {
            $total = $productDiscountPrice;
            $payable = $productPrice - $productDiscountPrice;
        }
        return ['total' => $total , 'payable' => $payable];
    }


    public function updateProductCount(array $data)
    {
        $cart = auth()->user()->cart;
        $items = $cart->items;
        $total = $items->sum(function ($item) use ($data){
            return $item->product_id != $data['product_id'] ?
                $item->quantity * $item->price :
                $data['quantity'] * $item->price;
        });
        $payable = $items->sum(function ($item) use ($data){
            return $item->product_id != $data['product_id'] ?
                $item->quantity * $item->price_with_discount :
                $data['quantity'] * $item->price_with_discount;
        });

        $payable = $total - $payable;
        $cart->total = $total;
        $cart->payable = $payable;
        $cart->update();
        CartItem::where('product_id',$data['product_id'])->update(['quantity' => $data['quantity']]);
        $this->data = $cart;
        return $this->returnData();
    }

    public function removeProduct(int $productId)
    {
        $cart = auth()->user()->cart;
        if (!is_null($cart)){
            CartItem::where(['cart_id' => $cart->id,'product_id' => $productId])->delete();
            if (!$cart->items->isEmpty()) {
                $total = $cart->items->sum(function ($item){
                    return $item->quantity * $item->price;
                });
                $payable = $cart->items->sum(function ($item){
                    return $item->quantity * $item->price_with_discount;
                });
                $payable = $total - $payable;
                $cart->total = $total;
                $cart->payable = $payable;
                $cart->update();
                $cart->load('items','items.product','items.product.images');
            } else {
                $cart->delete();
                $cart = null;
            }
        }
        $this->data = $cart;
        $this->message = trans('messages.deleted');
        return $this->returnData();
    }

    public function removeCart()
    {
       auth()->user()->cart->delete();
       $this->message = trans('messages.deleted');
       return $this->returnData();
    }
}
