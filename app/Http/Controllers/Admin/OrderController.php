<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\User;
use App\QueryFilters\CreateDate;
use App\QueryFilters\DateRange;
use App\QueryFilters\OrderSellerStatus;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::query()
            ->orderBy('created_at', 'desc');
        if (Auth::guard('admin_user')->check()) {
            if (Auth::guard('admin_user')->user()->hasRole('courier')) {
                $user = Auth::guard('admin_user')->user();
                $orders->with([
                    'detail.parentStatus', 'detail.product', 'user',
                    'detail' => function ($detail) use ($user) {
                        if (request('order_status') != '') {
                            $detail->where('status', request('order_status'));
                        }
                        $detail->where('kuryer_id', $user->id);
                    }
                ])->whereHas('detail', function ($q) use ($user) {
                    if (request('order_status') != '') {
                        $q->where('status', request('order_status'));
                    }
                    $q->where('kuryer_id', $user->id);
                });
            } else {
                $orders->with([
                    'detail.parentStatus', 'detail.product', 'user',
                    'detail' => function ($detail) {
                        if (request('order_status') != '') {
                            $detail->where('status', request('order_status'));
                        }
                    }
                ])->whereHas('detail', function ($q) {
                    if (request('order_status') != '') {
                        $q->where('status', request('order_status'));
                    }
                });
            }
        } elseif (Auth::guard('seller')->check()) {
            $user = Auth::guard('seller')->user();
            $orders->with([
                'detail.parentStatus', 'detail.product', 'user',
                'detail' => function ($detail) use ($user) {
                    if (request('order_status') != '') {
                        $detail->where('status', request('order_status'));
                    }
                    $detail->where('seller_id', $user->seller_id);
                }
            ])->whereHas('detail', function ($q) use ($user) {
                if (request('order_status') != '') {
                    $q->where('status', request('order_status'));
                }
                $q->where('seller_id', $user->seller_id);
            });
        }
        $orders->whereHas('detail')
            ->where(function ($query) {
                $query->whereDoesntHave('payment')
                    ->orWhereHas('payment', function ($query) {
                        $query->where('order_status', 'APPROVED');
                    });
            });
        $orders = app(Pipeline::class)
            ->send($orders)
            ->through([
                \App\QueryFilters\OrderType::class,
                \App\QueryFilters\OrderNumber::class,
                \App\QueryFilters\User::class,
                \App\QueryFilters\OrderPaymentType::class,
                \App\QueryFilters\OrderStatus::class,
                \App\QueryFilters\CreateDate::class,
                OrderSellerStatus::class,
                DateRange::class
            ])
            ->thenReturn()
            ->paginate(getPaginationLimit());
//        dd(\request(), $orders);
        $orderStatuses = OrderStatus::all();
        $kuryers = User::whereHas('roles', function ($q) {
            $q->where('role_id', 7);
        })->get();
//        dd($kuryers);
        return view('admin.orders.index', compact('orders', 'orderStatuses', 'kuryers'));
    }

    public function showDetail($orderId, $type)
    {
        $city = null;
        if ($type == 1) {
            $order = Order::select('address')->findOrFail($orderId);
            $city = City::select('name')->find($order->address['city']);
        } else {
            $order = OrderDetail::select('attributes')->findOrFail($orderId);
        }
        return view('admin.orders.orderDetailData', compact('order', 'city', 'type'));
    }

    public function deleteOrderDetail($detailId)
    {
        OrderDetail::findOrFail($detailId)->delete();
        return back()->with('success', 'Əməliyyat uğurla tamamlandı.');
    }

    public function updateOrderDetailStatus(Request $request)
    {
        if (Auth::guard('admin_user')->check()) {
            if (Auth::guard('admin_user')->user()->hasRole('courier')) {
                $user = Auth::guard('admin_user')->user();
                $request->validate([
                    'status' => 'required|integer',
                    'order_detail_id' => 'required|integer',
                    'kuryer_status' => 'required|integer|in:1,2,3,4',
                    'note' => 'nullable'
                ]);
                $orderDetail = OrderDetail::findOrFail($request->order_detail_id);
                $orderDetail->status = $request->status;
                if ($request->status == 7) {
                    if (!$request->has('reason_id3')) {
                        return ['errors' => ['reason_id' => ["Sebebi qedy edin"]]];
                    } elseif (!$request->reason_id3) {
                        return ['errors' => ['reason_id' => ["Sebebi qedy edin"]]];
                    } elseif (!array_key_exists($request->reason_id3, Order::ORDER_REFUND_STATUSES)) {
                        return ['errors' => ['reason_id' => ["Sebebi qedy edin"]]];
                    } else {
                        $orderDetail->kuryer_reason_id = $request->reason_id3;
                    }
                } else {
                    $orderDetail->kuryer_reason_id = 0;
                }
                $orderDetail->kuryer_status = $request->kuryer_status;
                $orderDetail->kuryer_note = $request->note ? $request->note : $orderDetail->note;
                $orderDetail->update();
                return response()->json(['success' => 'Əməliyyat uğurla tamamlandı.']);
            } else {
                $request->validate([
                    'order_detail_id' => 'required|integer',
                    'status' => 'required|integer|in:0,1,2,3,4,5,6,7',
                    'kuryer_id' => 'nullable|required_if:status,3|integer',
                    'kuryer_amount' => 'nullable|required_if:status,3|between:0,99999.99',
//                    'kuryer_status' => 'nullable|required_if:status,3|integer|in:1,2,3,4,5',
//                    'note' => 'nullable'
                ]);
                if ($request->status == 3) {
                    $kuryer = User::where('id', $request->kuryer_id)->first();
                    if (!$kuryer->hasRole('courier')) {
                        return ['errors' => ['kuryer_id' => ["Bele bir Kuryer Yoxdur"]]];
                    }
                }
//                dd($request->kuryer_id);
                $orderDetail = OrderDetail::findOrFail($request->order_detail_id);
                $orderDetail->status = $request->status;
                switch ($request->status) {
                    case 5:
                        if (!$request->has('reason_id1')) {
                            return ['errors' => ['reason_id' => ["Sebebi qedy edin"]]];
                        } elseif (!$request->reason_id1) {
                            return ['errors' => ['reason_id' => ["Sebebi qedy edin"]]];
                        } elseif (!array_key_exists($request->reason_id1, Order::ORDER_CANCEL_STATUSES)) {
                            return ['errors' => ['reason_id' => ["Sebebi qedy edin"]]];
                        } else {
                            $orderDetail->reason_id = $request->reason_id1;
                        }
                        break;
                    case 6:
                        if (!$request->has('reason_id2')) {
                            return ['errors' => ['reason_id' => ["Sebebi qedy edin"]]];
                        } elseif (!$request->reason_id2) {
                            return ['errors' => ['reason_id' => ["Sebebi qedy edin"]]];
                        } elseif (!array_key_exists($request->reason_id2, Order::ORDER_REJECT_STATUSES)) {
                            return ['errors' => ['reason_id' => ["Sebebi qedy edin"]]];
                        } else {
                            $orderDetail->reason_id = $request->reason_id2;
                        }
                        break;
                    case 7:
                        if (!$request->has('reason_id3')) {
                            return ['errors' => ['reason_id' => ["Sebebi qedy edin"]]];
                        } elseif (!$request->reason_id3) {
                            return ['errors' => ['reason_id' => ["Sebebi qedy edin"]]];
                        } elseif (!array_key_exists($request->reason_id3, Order::ORDER_REFUND_STATUSES)) {
                            return ['errors' => ['reason_id' => ["Sebebi qedy edin"]]];
                        } else {
                            $orderDetail->reason_id = $request->reason_id3;
                        }
                        break;
                }
                if ($request->status == 3) {
                    $orderDetail->kuryer_id = $request->kuryer_id;
                    $orderDetail->kuryer_amount = $request->kuryer_amount;
//                    $orderDetail->kuryer_note = $request->note;
//                    $orderDetail->kuryer_status = $request->kuryer_status;
                }
//                elseif (!in_array($request->status, [4, 5, 6, 7])) {
//                    $orderDetail->kuryer_id = null;
//                    $orderDetail->kuryer_amount = null;
//                    $orderDetail->kuryer_note = null;
//                    $orderDetail->kuryer_status = null;
//                    $orderDetail->reason_id = null;
//                    $orderDetail->kuryer_reason_id = null;
//                }
                $orderDetail->update();
                return response()->json(['success' => 'Əməliyyat uğurla tamamlandı.']);
            }
        } elseif (Auth::guard('seller')->check()) {
            $user = Auth::guard('seller')->user();
            $request->validate([
                'order_detail_id' => 'required|integer',
                'seller_status' => 'required|integer|in:1,2,3,4',
            ]);
            $orderDetail = OrderDetail::findOrFail($request->order_detail_id);
            if (!array_key_exists($request->seller_status, Order::ORDER_SELLER_STATUSES)) {
                return ['errors' => ['seller_status' => ["Statusu qedy edin"]]];
            } else {
                $orderDetail->seller_status = $request->seller_status;
            }
            $orderDetail->update();
            return response()->json(['success' => 'Əməliyyat uğurla tamamlandı.']);
        } else {
            return ['errors' => ['order_detail_id' => ["Something went wrong"]]];
        }
    }
}
