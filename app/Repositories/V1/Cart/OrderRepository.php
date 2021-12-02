<?php


namespace App\Repositories\V1\Cart;


use App\Models\City;
use App\Models\Color;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\UserAddress;
use App\Models\Variation;
use App\Repositories\V1\Contracts\OrderRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface
{
    use ApiResponder;

    private $paymentTypes = ['cash', 'online','payment_in_door'];

    public function makeOrder($data,$cartData)
    {
        if (auth('api')->check()){
            if ($cartData['code'] == JsonResponse::HTTP_OK) {
                $user = request()->user('api');
                $cart = $cartData['data'];
                $address = UserAddress::with('city')->firstWhere(['id' => $data['address'], 'user_id' => $user->id]);
                if (!$address) {
                    $this->status = JsonResponse::HTTP_BAD_REQUEST;
                    $this->message = 'Düzgün ünvan seçin!';
                    return $this->returnData();
                }
                $errors = array();

                foreach ($cart->items as $item) {
                    $product = Product::with(['attributes.attribute'])->firstWhere(['id' => $item->product_id, 'visible' => true]);
                    if ($product->has('attributes')) {
                        if ($product->has('attributes') == '') {
                            $this->status = JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
                            $this->message = 'Daxil edilən məlumatlar düzgün deyil.';
                            return $this->returnData();
                        }
                        $attributes = json_decode($item->attributes);
                        $variation = $this->getProductVariation($product, $attributes);
                        if ($variation && $variation->qty < $item->quantity) {
                            $a = ['item' => $item->id, 'stock' => $variation ? $variation->qty : 0];
                            array_push($errors, $a);
                        }
                    }
                }
                if (!empty($errors)) {
                    $this->status = JsonResponse::HTTP_BAD_REQUEST;
                    $this->message = 'quantity exceed';
                    return $this->returnData();
                }

                $_total = 0;
                $_payable = 0;
                $_discounts = 0;
                foreach ($cart->items as $item) {
                    $product = Product::firstWhere(['id' => $item->product_id, 'visible' => true]);
                    $discount = $this->getProductDiscount($product);
                    $_price = $product->price;
                    if (isset($variation)) $_price = $variation->price;
                    $_discounts += $discount;
                    $_payable += $_price * $item->quantity - $discount * $item->quantity;
                    $_total += $_price * $item->quantity;
                }
//                if ($request->input('isUrgent') == true) {
//                    $_payable += 2;
//                }

                $order = Order::query()->create([
                    'user_id' => $user->id,
                    'orderno' => substr(time(), -6) . rand(10, 99),
                    'total' => $_total,
                    'discount' => $_discounts,
                    'payed' => $_payable,
                    'address' => json_encode([
                        'user_name' => $address->user_name,
                        'phone_number' => $address->phone_number,
                        'city' => $address->city ? $address->city->name : $address->city_id,
                        'address' => $address->address,
                        'zip_code' => $address->zip_code,
                    ]),
                    'order_type' => 1,
                    'type' => 3,
                    'payment_type' => in_array($data['payment_type'],$this->paymentTypes) ? $data['payment_type'] : 'cash'
                ]);

                foreach ($cart->items as $item) {
                    $product = Product::with(['attributes.attribute'])->firstWhere(['id' => $item->product_id, 'visible' => true]);
                    if ($product->has('attributes')) {
                        if ($product->has('attributes') == '') {
                            $this->status = JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
                            $this->message = 'Daxil edilən məlumatlar düzgün deyil.';
                            return $this->returnData();
                        }
                        $attributes = json_decode($item->attributes);
                        $variation = $this->getProductVariation($product, $attributes);
                    }
                    if (isset($variation)) {
                        $variation->update(['qty' => DB::raw('qty - 1')]);
                    } else {
                        $product->update(['qty' => DB::raw('qty - 1')]);
                    }
                    OrderDetail::query()->create([
                        'order_id' => $order->id,
                        'seller_id' => $product->seller_id,
                        'product_id' => $product->id,
                        'price' => $product->price,
                        'discount' => $this->getProductDiscount($product),
                        'quantity' => $item->quantity,
                        'attributes' => $item->attributes,
                        'stock' => 0,
                        'status' => 1,
                    ]);
                }
                $cart->items()->delete();
                $cart->delete();

//                if ($request->input('payment_type') == "cash") {
                    $this->status = JsonResponse::HTTP_CREATED;
                    $this->message = 'Sifariş tamamlandı';

                    return $this->returnData();
//                } else {
//                    $data = (new PaymentController())->createOrder($order, []);
//                    return $this->sendResponse(['url' => $data], '', 201);
//                }
            } else {
                $this->status = JsonResponse::HTTP_NOT_FOUND;
                $this->message = 'Empty Cart';
                return $this->returnData();
            }
        } else {
            $errors = [];
            $requestProduct = $data['products'];
            foreach ($requestProduct as $item) {
                $product = Product::with(['attributes.attribute'])->firstWhere(['id' => $item['id'], 'visible' => 1]);
                if ($product->has('attributes')) {
                    if ($product->has('attributes') == '') {
                        $this->status = JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
                        $this->message = 'Daxil edilən məlumatlar düzgün deyil.';
                        return $this->returnData();
                    }
                    $attributes = json_decode($item['attributes']);
                    $variation = $this->getProductVariation($product, $attributes);
                    if ($variation && $variation->qty < $item['qty']) {
                        $a = ['item' => $item['id'], 'stock' => $variation ? $variation->qty : 0];
                        array_push($errors, $a);
                    }
                }
            }

            if (!empty($errors)) {
                $this->status = JsonResponse::HTTP_BAD_REQUEST;
                $this->message = 'quantity exceed';
                return $this->returnData();
            }

            $total = 0;
            $payable = 0;
            $discounts = 0;

//            try {
                foreach ($requestProduct as $item) {
                    $product = Product::firstWhere(['id' => $item['id'], 'visible' => 1]);
                    $discount = $this->getProductDiscount($product);
                    $discounts += $discount;
                    $payable += $product->price * $item['qty'] - $discount;
                    $total += $product->price * $item['qty'];
                }
//
//                if ($request->input('isUrgent') == true) {
//                    $payable += 3;
//                }
                $city = City::find($data['city_id']);
                $order = Order::query()->create([
                    'user_id' => null,
                    'orderno' => substr(time(), -6) . rand(10, 99),
                    'total' => $total,
                    'discount' => $discounts,
                    'payed' => $payable,
                    'address' => json_encode([
                        'user_name' => $data['fullname'],
                        'phone_number' => $data['phone'],
                        'city' => $city->name,
                        'address' => $data['address'],
                        'zip_code' => isset($data['zip_code']) ? $data['zip_code'] : null,
                    ]),
                    'order_type' => 1,
                    'type' => 3,
                    'payment_type' => in_array($data['payment_type'],$this->paymentTypes) ? $data['payment_type'] : 'cash'
                ]);

                foreach ($requestProduct as $prdct) {
                    $product = Product::with(['attributes.attribute'])->firstWhere(['id' => $prdct['id'], 'visible' => 1]);
                    $discount = $this->getProductDiscount($product);
                    if ($product->has('attributes')) {
                        $attributes = json_decode($prdct['attributes']);
                        $variation = $this->getProductVariation($product, $attributes);
                    }
                    if (isset($variation)) {
                        $variation->update(['qty' => DB::raw('qty - 1')]);
                    } else {
                        $product->update(['qty' => DB::raw('qty - 1')]);
                    }
                    OrderDetail::query()->create([
                        'order_id' => $order->id,
                        'seller_id' => $product->seller_id,
                        'product_id' => $product->id,
                        'price' => $product->price,
                        'discount' => $discount,
                        'quantity' => $prdct['qty'],
                        'attributes' => $prdct['attributes'],
                        'stock' => 0,
                        'status' => 1,
                    ]);
                }
                $this->status = JsonResponse::HTTP_CREATED;
                $this->message = 'Sifariş tamamlandı';

                return $this->returnData();

//            }catch (\Exception $e){
//
//            }
        }
    }

    public function payDirectly($data,$id)
    {
        $user = request()->user('api');
        $product = Product::with(['attributes.attribute'])->findOrFail($id);
        if ($product->has('attributes')) {
            if ($product->has('attributes') == '') {
                $this->status = JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
                $this->message = 'Daxil edilən məlumatlar düzgün deyil.';
                return $this->returnData();
            }
            $attributes = json_decode($data['attributes']);
            $variation = $this->getProductVariation($product, $attributes);
            if ($variation && $variation->qty < 1) {
                $this->status = JsonResponse::HTTP_NOT_FOUND;
                $this->message = 'max quantity';
                return $this->returnData();
            }
        }
        try {
            $total = $product->price;
            if (isset($variation)) {
                $total = $variation->price;
            }
            $discount = $this->getProductDiscount($product);
            $payable = $product->price - $discount;
            $city = City::find($data['city']);
            $order = Order::query()->create([
                'user_id' => null,
                'orderno' => substr(time(), -6) . rand(10, 99),
                'total' => $total,
                'discount' => $discount,
                'payed' => $payable,
                'address' => json_encode([
                    'user_name' => $data['first_name']. '' .$data['last_name'],
                    'phone_number' => $data['phone'],
                    'city' => $city->name,
                    'address' => $data['address'],
                    'zip_code' => isset($data['zip_code']) ? $data['zip_code'] : null,
                ]),
                'order_type' => 1,
                'type' => 1,
                'payment_type' => in_array($data['payment_type'],$this->paymentTypes) ? $data['payment_type'] : 'cash'
            ]);
            if ($user) {
                $order->user_id = $user->id;
            }
            if (isset($variation)) {
                $variation->update(['qty' => DB::raw('qty - 1')]);
            } else {
                $product->update(['qty' => DB::raw('qty - 1')]);
            }
            OrderDetail::query()->create([
                'order_id' => $order->id,
                'seller_id' => $product->seller_id,
                'product_id' => $product->id,
                'price' => $product->price,
                'discount' => $discount,
                'quantity' => 1,
                'attributes' => $data['attributes'],
                'stock' => 0,
                'status' => 1,
            ]);

            $this->status = JsonResponse::HTTP_CREATED;
            $this->message = 'Sifariş tamamlandı';

            return $this->returnData();
//            if ($request->input('payment_type') == "cash") {
//                return $this->sendResponse(null, 'success', 201);
//            } else {
//                $data = (new PaymentController())->createOrder($order, []);
//                if ($data != false) {
//                    return $this->sendResponse(['success' => true, 'url' => $data], '', 201);
//                }
//                return $this->sendResponse(['success' => false, 'url' => ''], 'Sifariş tamamlanmadı', 500);
//            }
        } catch (\Exception $e) {
            $this->status = JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
            $this->message = 'Xeta bas verdi';

            return $this->returnData();
        }
    }

    private function getProductVariation(Product $product, $attributes)
    {
        $color = $attributes->color ? Color::firstWhere(['name' => $attributes->color]) : '';
        $variation = Variation::where(['product_id' => $product->id]);
        if ($color) {
            $variation->where(['color_id' => $color->id]);
        }
        if ($attributes->size) {
            $variation->where(['variation' => $attributes->size]);
        }
        return $variation = $variation->first();
    }

    private function getProductDiscount(Product $product)
    {
        $discount = 0;
        if ((float) $product->discount_price != 0) {
            if ($product->discount_type == 1) {
                $discount = $product->discount_price;
            } else {
                $discount = $product->price * $product->discount_price / 100;
            }
        }
        return $discount;
    }

    public function getOrdersByUser()
    {
        $user = auth('api')->user();
        $orders = Order::where('user_id' , $user->id)->withCount('items')->get();
        $this->data = $orders;

        return $this->returnData();
    }

    public function getOrderItemsByOrder(int $orderId)
    {
        $user = auth('api')->user();
        $order = Order::where(['user_id' => $user->id,'id' => $orderId])
            ->with('items','items.itemStatus','items.product','items.product.images')
            ->get();
        if ($order->isNotEmpty()) {
            $this->data = $order[0]->items;
        } else {
            $this->status = JsonResponse::HTTP_NOT_FOUND;
            $this->message = trans('messages.model_not_found');
        }

       return $this->returnData();
    }

    public function getOrderItemsByUser()
    {
        $orderItems = OrderDetail::whereHas('order',function ($order){
            $order->where('user_id',auth('api')->user()->id);
        })->with('order','product','product.images','productRate','itemStatus')->get();
       $this->data = $orderItems;

       return $this->returnData();
    }

    public function getOrderItemsByOrderNumber($orderNumber)
    {
        $orderItems = OrderDetail::whereHas('order',function ($order) use($orderNumber){
            $order->where('orderno',$orderNumber);
        })->with('order','product','product.images','itemStatus')->get();
        $this->data = $orderItems;

        return $this->returnData();
    }
}
