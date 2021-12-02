<?php


namespace App\Repositories\V1\Cart;


use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Color;
use App\Models\Product;
use App\Models\Variation;
use App\Repositories\V1\Contracts\CartRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CartRepository implements CartRepositoryInterface
{
    use ApiResponder;

    public function getCart()
    {
        if (auth('api')->check()){
            $user = auth('api')->user();
            $user->load('cart','cart.items','cart.items.product','cart.items.product.images');
            $this->data = $user->cart;
        } else {
            $this->status = JsonResponse::HTTP_NOT_FOUND;
        }

        return $this->returnData();
    }

    public function store(array $data)
    {
        $user = auth()->user();
        $discount = 0;
        $product = Product::with('brand')->findOrFail($data['product_id']);
        $price = $product->price;
        $attributes = isset($data['attributes']) ? json_decode($data['attributes'], true) : [];
        $color = isset($attributes['color']) ? Color::firstWhere(['name' => $attributes['color']]) : null;
        if (is_null($color)) {
            $this->status = JsonResponse::HTTP_NOT_FOUND;
            $this->message = 'color not exists';
            return $this->returnData();
        }
        $variation = Variation::where(['product_id' => $product->id, 'color_id' => $color->id, 'variation' => $attributes['size']])->first();
        if (!$variation) {
            $this->status = JsonResponse::HTTP_NOT_FOUND;
            $this->message = 'size not exists';
            return $this->returnData();
        }

        if ($product->discount_type == 1) {
            $discount += ($data['quantity'] * $product->discount_price);
            $price -= $product->discount_price;
        } else {
            $discount += ($data['quantity'] * ($price * ($product->discount_price / 100)));
            $price -= ( $data['quantity'] * ($price * ($product->discount_price / 100)));
        }

        $cart = Cart::firstWhere(['user_id' => $user->id]);
        if ($cart) {
            $cart->discount = (float) $cart->discount + $discount;
            $cart->total = (float) $cart->total + $product->price;
            $cart->payable = (float) $cart->payable + $price;
            $cart->save();
        } else {
            $cart = Cart::query()->create(
                [
                    'user_id' => $user->id,
                    'discount' => (float) number_format($discount, 2, '.', ''),
                    'total' => (float) number_format($product->price, 2, '.', ''),
                    'payable' => (float) number_format($product->price - $discount, 2, '.', ''),
                ]
            );
        }
        $cartItem = CartItem::query()->firstWhere([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'attributes' =>$data['attributes'],
        ]);
        if ($cartItem) {
            if ($cartItem->quantity + 1 > $variation->qty) {
                $this->status = JsonResponse::HTTP_NOT_FOUND;
                $this->message = 'max quantity';
                return $this->returnData();
            }
            $cartItem->update([
                'name' => $product->title,
                'price' => $product->price,
                'quantity' => DB::raw("(1 + quantity)"),
            ]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $data['quantity'],
                'attributes' => $data['attributes'],
            ]);
        }
        $cart->load('items','items.product');
        $this->data = $cart;
        $this->message = trans('messages.created');

        return $this->returnData();
    }

    public function updateProductCount(array $data)
    {
       $user = auth()->user();
       $discount = 0;
        $cartItem = CartItem::with(['product', 'cart','cart.items','cart.items.product'])->where(['id' => $data['item_id']])->firstOrFail();
        $cart = $cartItem->cart;

        if ($cart->user_id == $user->id) {
            $product = $cartItem->product;
            $attributes = json_decode($cartItem->attributes, true);
            $color = $attributes['color'] ? Color::firstWhere(['name' => $attributes['color']]) : null;
            $variation = Variation::where(['product_id' => $product->id, 'color_id' => $color->id, 'variation' => $attributes['size']])->first();

            if ($data['quantity']  > $variation->qty) {
                $this->status = JsonResponse::HTTP_NOT_FOUND;
                $this->message = 'max quantity';
                return $this->returnData();
            }
            $price = $product->price;
            if ($product->discount_type == 1) {
                $discount += ($data['quantity'] * $product->discount_price);
                $price -= $product->discount_price;
            } else {
                $discount += ($data['quantity'] * ($price * ($product->discount_price / 100)));
                $price -= ( $data['quantity'] * ($price * ($product->discount_price / 100)));
            }
            if ($cart && $cartItem) {
                if ($cartItem->quantity < $data['quantity']){
                    $cart->discount = (float) $cart->discount + $discount;
                    $cart->total = (float) $cart->total + $product->price;
                    $cart->payable = (float) $cart->payable + $price;
                } else if($cartItem->quantity > $data['quantity']){
                    $cart->discount = (float) $cart->discount - $discount;
                    $cart->total = (float) $cart->total - $product->price;
                    $cart->payable = (float) $cart->payable - $price;
                }

                $cart->save();
                $cartItem->quantity = $data['quantity'];
                $cartItem->save();
            }
            return $this->returnData();
        } else {
            $this->status = JsonResponse::HTTP_NOT_FOUND;
            $this->message = 'invalid cart id';
            return $this->returnData();
        }
    }

    public function removeProduct(int $itemId)
    {
        $user = auth()->user();
        $discount = 0;
        $cartItem = CartItem::with(['product', 'cart','cart.items','cart.items.product'])->where(['id' => $itemId])->firstOrFail();
        $cart = $cartItem->cart;
        if ($cart->user_id == $user->id) {
            $product = $cartItem->product;
            $price = $product->price;

            if ($product->discount_type == 1) {
                $discount += $product->discount;
                $price -= $product->discount;
            } else {
                $discount += $price * $product->discount / 100;
                $price -= $price * $product->discount / 100;
            }

            if ($cart) {
                $cart->discount = (float) $cart->discount - $discount * $cartItem->quantity;
                $cart->total = (float) $cart->total - $product->price * $cartItem->quantity;
                $cart->payable = (float) $cart->payable - $price * $cartItem->quantity;
                $cart->save();
                if ($cart->items()->count() == 1) {
                    $cart->delete();
                } else {
                    $cartItem->delete();
                }
            }
            $this->data = $cart;
            return $this->returnData();

        }else {
            $this->status = JsonResponse::HTTP_NOT_FOUND;
            $this->message = 'invalid cart id';
            return $this->returnData();
        }
    }

    public function removeCart()
    {
        auth()->user()->cart->delete();
        $this->message = trans('messages.deleted');
        return $this->returnData();
    }
}
