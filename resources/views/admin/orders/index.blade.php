@extends('layouts.app',['title'=>"Orders"])

@section('breadcrump')
    <div class="top-section b-black">
        <div class="container">
            <div class="top-section-inner">
                <div>
                    <div class="page-links">
                        <a class="c-white-op-75 f-size-14">Ana səhifə > </a>
                        <span class="c-white-op-50 f-size-14">
                                Sifarişlər
                            </span>
                    </div>
                    <h6 class="f-size-24 c-white">
                        Sifarişlər
                    </h6>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @php
        $order_status=request()->has('order_status') ? request('order_status') : '';
        $adminRole = \Illuminate\Support\Facades\Auth::guard('admin_user')->check() ?  (\Illuminate\Support\Facades\Auth::guard('admin_user')->user()->hasRole('admin') ? true : false) : false;
        $courierRole = \Illuminate\Support\Facades\Auth::guard('admin_user')->check() ?  (\Illuminate\Support\Facades\Auth::guard('admin_user')->user()->hasRole('courier') ? true : false) : false;
        $sellerRole = \Illuminate\Support\Facades\Auth::guard('seller')->check() ?  (\Illuminate\Support\Facades\Auth::guard('seller')->user()->hasRole('seller') ? true : false) : false;
    @endphp
    <style>
        .error-input {
            border: 1px solid red;
        }
    </style>
    <div class="homepage-content b-white-1">
        <div class="container">
            <ul class="tabs-header b-white">
                @if ($adminRole || $sellerRole)
                    <li>
                        <a href="{{ request()->fullUrlWithQuery(['order_status' => '']) }}"
                           class="f-size-14 c-black-op-50 {{ is_null(request('order_status')) ? 'active' : '' }}">
                            Hamısı
                        </a>
                    </li>
                    @foreach ($orderStatuses as $status)
                        <li>
                            <a href="{{ request()->fullUrlWithQuery(['order_status' => $status->id]) }}"
                               class="f-size-14 c-black-op-50 {{ !is_null(request('order_status')) && request('order_status') == $status->id ? 'active' : '' }}">
                                {{ $status->title }}
                            </a>
                        </li>
                    @endforeach
                @elseif($courierRole)
                    @foreach($orderStatuses as $status)
                        @if(in_array($status->id,[3,4,7]))
                            <li>
                                <a href="{{ request()->fullUrlWithQuery(['order_status' => $status->id]) }}"
                                   class="f-size-14 c-black-op-50 {{ !is_null(request('order_status')) && request('order_status') == $status->id ? 'active' : '' }}">
                                    {{ $status->title }}
                                </a>
                            </li>
            @endif
            @endforeach
            @endif

        </div>
        <form class="search-bar" action="{{request()->fullUrl()}}" method="get">
            <input type="hidden" name="order_status"
                   value="{{!is_null(request('order_status'))  ? request('order_status'): ''}}">
            <div class="container">
                <div class="row">
                    <div class="xl-2">
                        <label for="" class="label-class c-dblack-50 f-size-14 mb-12">
                            Növ
                        </label>
                        <div class="mobile-select">
                            <div class="selectHolder selectThin">
                                <select name="order_type" id="">
                                    <option value="">Hamısı</option>
                                    <option {{request('order_type') == 1 ? 'selected' : ''}} value="1">Birbaşa</option>
                                    <option {{request('order_type') == 2 ? 'selected' : ''}} value="2">Səbətdən</option>
                                    <option {{request('order_type') == 3 ? 'selected' : ''}} value="3">Səbətdən
                                        birbaşa
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="xl-2">
                        <label for="" class="label-class c-dblack-50 f-size-14 mb-12">
                            Sifariş ID
                        </label>
                        <input type="text" name="order_number" class="input-class" value="{{request('order_number')}}">
                    </div>
                    <div class="xl-2">
                        <label for="" class="label-class c-dblack-50 f-size-14 mb-12">
                            Ad, Soyad
                        </label>
                        <input type="text" name="user[name]" class="input-class" value="{{request('user.name')}}">
                    </div>
                    <div class="xl-2">
                        <label for="" class="label-class c-dblack-50 f-size-14 mb-12">
                            Telefon
                        </label>
                        <input type="text" name="user[phone]" class="input-class" value="{{request('user.phone')}}">
                    </div>
                    <div class="xl-2">
                        <label for="" class="label-class c-dblack-50 f-size-14 mb-12">
                            E-mail
                        </label>
                        <input type="text" name="user[email]" class="input-class" value="{{request('user.email')}}">
                    </div>
                    <div class="xl-2">
                        <label for="" class="label-class c-dblack-50 f-size-14 mb-12">
                            Ödəmə
                        </label>
                        <div class="mobile-select">
                            <div class="selectHolder selectThin">
                                <select name="order_payment_type" id="">
                                    <option value="">Hamısı</option>
                                    <option
                                        {{request('order_payment_type') == 'online' ? 'selected' : ''}} value="online">
                                        Onlayn
                                    </option>
                                    <option {{request('order_payment_type') == 'cash' ? 'selected' : ''}} value="cash">
                                        Nəğd
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="xl-2">
                        <label for="" class="label-class c-dblack-50 f-size-14 mb-12">
                            Mağaza Statusları
                        </label>
                        <div class="mobile-select">
                            <div class="selectHolder selectThin">
                                <select name="order_seller_status" id="">
                                    <option value="">Hamısı</option>
                                    @foreach(\App\Models\Order::ORDER_SELLER_STATUSES as $key=>$value)
                                        <option value="{{$key}}" {{!is_null(request('order_status')) && request('order_status') ==
                                        $status->id ? 'selected' : ''}}>{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="xl-4">
                        <div class="search-bars-right">
                            <div class="date-parent">
                                <label for="" class="label-class c-dblack-50 f-size-14 mb-12">
                                    Tarix aralığı
                                </label>
                                <input type="text" class="input-class date-class dateRange"
                                       value="{{request('create_date')}}" name="daterange">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <g opacity="0.5">
                                        <path
                                            d="M3.73333 0V5.33333M12.2667 0V5.33333M3.19999 8H6.39999M12.8 8H9.59999M3.19999 11.2H6.39999M9.59999 11.2H12.8M1.59999 2.66667H14.4C14.9891 2.66667 15.4667 3.14423 15.4667 3.73333V14.4C15.4667 14.9891 14.9891 15.4667 14.4 15.4667H1.59999C1.01089 15.4667 0.533325 14.9891 0.533325 14.4V3.73333C0.533325 3.14423 1.01089 2.66667 1.59999 2.66667Z"
                                            stroke="#0B0B18"/>
                                    </g>
                                </svg>
                            </div>
                            <div class="search-buttons">
                                <a href="{{request()->url()}}" class="search-delete">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <g opacity="0.5">
                                            <path d="M1.59998 1.59998L14.4 14.4M1.59998 14.4L14.4 1.59998"
                                                  stroke="#0B0B18"/>
                                        </g>
                                    </svg>
                                </a>
                                <button type="submit" class="search-button b-black bradius-4">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M15.4667 15.4667L11.2 11.2M6.93332 13.3333C3.3987 13.3333 0.533325 10.4679 0.533325 6.93332C0.533325 3.3987 3.3987 0.533325 6.93332 0.533325C10.4679 0.533325 13.3333 3.3987 13.3333 6.93332C13.3333 10.4679 10.4679 13.3333 6.93332 13.3333Z"
                                            stroke="white"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="search-result-parent">
            <div class="container">
                <div class="search-result">
                    <div class="search-result-header">
                            <span class="f-size-14 search-esult-span c-dblack-75">
                                {{$orders->total()}} nəticə
                            </span>
                        <button class="delete-search-result">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <path
                                        d="M5.25714 3.32143V1.92857C5.25714 1.41574 5.66648 1 6.17143 1H9.82857C10.3335 1 10.7429 1.41574 10.7429 1.92857V3.32143M1 3.78571H15M3.37143 3.78571V13.0714C3.37143 13.5843 3.78077 14 4.28571 14H11.7143C12.2192 14 12.6286 13.5843 12.6286 13.0714V3.78571M8 6.62958V10.2277V11.4175"
                                        stroke="#05061E"/>
                                </g>
                            </svg>
                            <span class="f-size-14">
                                    Sil
                                </span>
                        </button>
                    </div>
                    <div class="search-result-body">
                        <div class="table-content-overflow">
                            <table class="search-result-table-overflow search-result-table">
                                <tr>
                                    <th class="search-result-table-th">
                                        <label class="checkbox-parent">
                                            <input type="checkbox" id="checkParent" class="checkbox-table">
                                            <span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th>Növ</th>
                                    <th>Sifariş ID</th>
                                    <th>Fullname</th>
                                    <th>Email</th>
                                    <th>Telefon</th>
                                    <th>Ödəmə</th>
                                    <th>Çatdırılma</th>
                                    <th>Total</th>
                                    <th>Tarix</th>
                                    <th>Ünvan</th>
                                    <th class="td-row">Sifarişlər</th>
                                    <th class="td-row">Magaza</th>
                                    <th>Thumbnail</th>
                                    <th>Say</th>
                                    {{--                                    <th>Stok</th>--}}
                                    {{--                                    <th>Rəf</th>--}}
                                    <th>Qiymət</th>
                                    <th>Endirimli</th>
                                    @if($adminRole || $courierRole)
                                        <th>Kuryerin Adi</th>
                                        <th>Kuryerin Statusu</th>
                                        <th>Kuryerin Qazanci</th>
                                        <th>Note</th>
                                    @endif
                                    <th>Status</th>
                                    <th>Magaza Status</th>
                                    @if($adminRole || $courierRole)
                                        <th>Sebeb</th>
                                    @endif
                                    @if($adminRole || $courierRole)
                                        <th>Kuryer Sebeb</th>
                                    @endif
                                    <th>Alətlər</th>
                                    <th class="right-button-parent">Tənzimləmələr</th>
                                </tr>
                                @forelse($orders as $item)
                                    <tr>
                                        <td class="search-result-table-td">
                                            <label class="checkbox-parent ">
                                                <input type="checkbox" class="checkbox-table">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            @switch($item->order_type)
                                                @case(1)
                                                Birbaşa
                                                @break
                                                @case(2)
                                                Səbətdən birbaşa
                                                @break
                                                @case(3)
                                                Səbətdən
                                                @break
                                                @default
                                                Seçilməyib
                                            @endswitch
                                        </td>
                                        <td>{{$item->orderno}}</td>
                                        <td>{{$item->user ? $item->user->full_name: ''}}</td>
                                        <td>{{$item->user ?$item->user->email : ''}}</td>
                                        <td>{{$item->user ?$item->user->phone_number: ''}}</td>
                                        <td>
                                            @switch($item->payment_type)
                                                @case('cash')
                                                Nəğd
                                                @break
                                                @case('online')
                                                Onlayn
                                                @break
                                                @default
                                                Seçilməyib
                                            @endswitch
                                        </td>
                                        <td>
                                            @switch($item->is_urgent)
                                                @case(0)
                                                Gün ərzində
                                                @break
                                                @case(1)
                                                Sürətli
                                                @break
                                                @default
                                                Seçilməyib
                                            @endswitch
                                        </td>
                                        <td>{{$item->total}}</td>
                                        <td>{{$item->created_at->format('d/m/Y')}}</td>
                                        <td>
                                            <button
                                                data-url="{{route('orders.showDetail',['orderId' => $item->id,'type' => 1])}}"
                                                type="button"
                                                class="table-button-black search-button b-black bradius-4 showDetail">
                                                Bax
                                            </button>
                                        </td>
                                        <td class="td-padding">
                                            <table>
                                                @foreach($item->detail  as $detail)
                                                    <tr>
                                                        <td>
                                                            <div class="table-div table-img-div">
                                                                {{$detail->product->name}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                        <td class="td-padding">
                                            <table>
                                                @foreach($item->detail  as $detail)
                                                    <tr>
                                                        <td>
                                                            <div class="table-div table-img-div">
                                                                {{$detail->store_detail?$detail->store_detail->full_name :''}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                        <td class="td-padding">
                                            <table>
                                                @foreach($item->detail as $detail)
                                                    <tr>
                                                        <td>
                                                            <div class="table-div table-img-div">
                                                                <img
                                                                    src="{{asset('storage/'.($detail->product?$detail->product->thumbnail :''))}}"
                                                                    class="table-img" alt="">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                        <td class="td-padding">
                                            <table>
                                                @foreach($item->detail as $detail)
                                                    <tr>
                                                        <td>
                                                            <div class="table-div table-img-div">
                                                                {{$detail->quantity}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>

                                        {{--                                        @if (in_array(auth()->user()->roles[0]->id, [1,4]))--}}
                                        {{--                                            <td class="td-padding">--}}
                                        {{--                                                <table>--}}
                                        {{--                                                    @foreach($item->detail as $detail)--}}
                                        {{--                                                        <tr>--}}
                                        {{--                                                            <td>--}}
                                        {{--                                                                <label for="product-{{$detail->id}}"--}}
                                        {{--                                                                       class="table-img-div">--}}
                                        {{--                                                                    <div class="private f-size-14-b c-dblack-75">--}}
                                        {{--                                                                        <div class="checkboxes">--}}
                                        {{--                                                                            <div class="check">--}}
                                        {{--                                                                                <input type="checkbox"--}}
                                        {{--                                                                                       data-item="{{$detail->id}}"--}}
                                        {{--                                                                                       @if ($detail->stock == 0) checked="checked"--}}
                                        {{--                                                                                       @endif class="productStockCount"--}}
                                        {{--                                                                                       id="product-{{$detail->id}}">--}}
                                        {{--                                                                                <label--}}
                                        {{--                                                                                    for="product-{{$detail->id}}"></label>--}}
                                        {{--                                                                            </div>--}}
                                        {{--                                                                        </div>--}}
                                        {{--                                                                    </div>--}}
                                        {{--                                                                </label>--}}
                                        {{--                                                            </td>--}}
                                        {{--                                                        </tr>--}}
                                        {{--                                                    @endforeach--}}
                                        {{--                                                </table>--}}
                                        {{--                                            </td>--}}
                                        {{--                                            <td class="td-padding">--}}
                                        {{--                                                <table>--}}
                                        {{--                                                    @foreach($item->detail as $detail)--}}
                                        {{--                                                        <tr>--}}
                                        {{--                                                            <td>--}}
                                        {{--                                                                <div class="table-div table-img-div">--}}
                                        {{--                                                                    {{$detail->product->shelf->name ?? 'Seçilməyib'}}--}}
                                        {{--                                                                </div>--}}
                                        {{--                                                            </td>--}}
                                        {{--                                                        </tr>--}}
                                        {{--                                                    @endforeach--}}
                                        {{--                                                </table>--}}
                                        {{--                                            </td>--}}
                                        {{--                                        @endif--}}
                                        <td class="td-padding">
                                            <table>
                                                @foreach($item->detail as $detail)
                                                    <tr>
                                                        <td>
                                                            <div class="table-div table-img-div">
                                                                {{$detail->price}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                        <td class="td-padding">
                                            <table>
                                                @foreach($item->detail as $detail)
                                                    <tr>
                                                        <td>
                                                            <div class="table-div table-img-div">
                                                                {{$detail->discount}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                        {{--                                        //Kuryer--}}
                                        @if ($courierRole || $adminRole)
                                            <td class="td-padding">
                                                <table>
                                                    @foreach ($item->detail as $detail)
                                                        <tr>
                                                            <td>
                                                                <div class="table-div table-img-div">
                                                                    {{$detail->kuryer_detail ? $detail->kuryer_detail->full_name : ''}}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                            <td class="td-padding">
                                                <table>
                                                    @foreach ($item->detail as $detail)
                                                        <tr>
                                                            <td>
                                                                <div class="table-div table-img-div">
                                                                    {{ $detail->kuryer_status ? (\Illuminate\Support\Arr::has(\App\Models\Order::ORDER_KURYER_STATUSES,[$detail->kuryer_status]) ? \App\Models\Order::ORDER_KURYER_STATUSES[$detail->kuryer_status] : '') : '' }}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                            <td class="td-padding">
                                                <table>
                                                    @foreach ($item->detail as $detail)
                                                        <tr>
                                                            <td>
                                                                <div class="table-div table-img-div">
                                                                    {{ $detail->kuryer_amount }} man
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                            <td class="td-padding">
                                                <table>
                                                    @foreach ($item->detail as $detail)
                                                        <tr>
                                                            <td>
                                                                <div class="table-div table-img-div">
                                                                    {{ $detail->kuryer_note }}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                        @endif
                                        {{--                                        EndKuryer--}}
                                        <td class="td-padding">
                                            <table>
                                                @foreach($item->detail as $detail)
                                                    <tr>
                                                        <td>
                                                            <div class="table-div table-img-div">
                                                                {{$detail->parentStatus ? $detail->parentStatus->title :''}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                        <td class="td-padding">
                                            <table>
                                                @foreach($item->detail as $detail)
                                                    <tr>
                                                        <td>
                                                            <div class="table-div table-img-div">
                                                                {{ $detail->seller_status ? (\Illuminate\Support\Arr::has(\App\Models\Order::ORDER_SELLER_STATUSES,[$detail->seller_status]) ? \App\Models\Order::ORDER_SELLER_STATUSES[$detail->seller_status] : '') : '' }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                        @if($adminRole || $courierRole)
                                            <td class="td-padding">
                                                <table>
                                                    @foreach($item->detail as $detail)
                                                        <tr>
                                                            <td>
                                                                <div class="table-div table-img-div">
                                                                    @switch($detail->status)
                                                                        @case(5)
                                                                        {{ $detail->reason_id ? (\Illuminate\Support\Arr::has(\App\Models\Order::ORDER_CANCEL_STATUSES,[$detail->reason_id]) ? \App\Models\Order::ORDER_CANCEL_STATUSES[$detail->reason_id] : '') : '' }}
                                                                        @break

                                                                        @case(6)
                                                                        {{ $detail->reason_id ? (\Illuminate\Support\Arr::has(\App\Models\Order::ORDER_REJECT_STATUSES,[$detail->reason_id]) ? \App\Models\Order::ORDER_REJECT_STATUSES[$detail->reason_id] : '') : '' }}
                                                                        @break

                                                                        @case(7)
                                                                        {{ $detail->reason_id ? (\Illuminate\Support\Arr::has(\App\Models\Order::ORDER_REFUND_STATUSES,[$detail->reason_id]) ? \App\Models\Order::ORDER_REFUND_STATUSES[$detail->reason_id] : '') : '' }}
                                                                        @break
                                                                    @endswitch
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                        @endif
                                        @if($adminRole || $courierRole)
                                            <td class="td-padding">
                                                <table>
                                                    @foreach($item->detail as $detail)
                                                        <tr>
                                                            <td>
                                                                <div class="table-div table-img-div">
                                                                    {{ $detail->kuryer_reason_id ? (\Illuminate\Support\Arr::has(\App\Models\Order::ORDER_REFUND_STATUSES,[$detail->kuryer_reason_id]) ? \App\Models\Order::ORDER_REFUND_STATUSES[$detail->kuryer_reason_id] : '') : '' }}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                        @endif
                                        <td class="td-padding">
                                            <table>
                                                @foreach($item->detail as $detail)
                                                    <tr>
                                                        <td>
                                                            <div class="table-div table-img-div"
                                                                 style="display: flex; align-items: center">

                                                                {{--                                                                @if (in_array(auth()->user()->roles[0]->id, [1]))--}}
                                                                <button data-status="{{$detail->status}}"
                                                                        data-orderdetail="{{$detail->id}}"
                                                                        data-kuryer_id="{{$detail->kuryer_id}}"
                                                                        data-kuryer_status_id="{{$detail->kuryer_status}}"
                                                                        data-kuryer_odenis="{{$detail->kuryer_amount}}"
                                                                        data-kuryer_note="{{$detail->kuryer_note}}"
                                                                        data-reason_id="{{$detail->reason_id}}"
                                                                        data-kuryer_reason_id="{{$detail->kuryer_reason_id}}"
                                                                        data-seller_status="{{$detail->seller_status}}"
                                                                        type="button"
                                                                        style="color: white"
                                                                        class="table-button-black search-button b-black bradius-4 changeStatus">
                                                                    Statusu dəyiş
                                                                </button>
                                                                {{--                                                                @endif--}}
                                                                <button style="margin-left: 5px"
                                                                        data-url="{{route('orders.showDetail',['orderId' => $detail->id,'type' => 2])}}"
                                                                        type="button"
                                                                        class="table-button-black search-button b-black bradius-4 showDetail hd1">
                                                                    Detallar
                                                                </button>

                                                                {{--                                                                @if (in_array(auth()->user()->roles[0]->id, [1]))--}}
                                                                <button style="margin-left: 5px"
                                                                        data-url="{{route('orders.deleteOrderDetail',['detailId' => $detail->id])}}"
                                                                        type="button"
                                                                        class="table-button-black search-button b-black bradius-4 deleteDetail">
                                                                    Sil
                                                                </button>
                                                                {{--                                                                @endif--}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                        <td class="right-button-parent">
                                            <div class="right-buttons">
                                                <button class="table-buttons">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <g opacity="0.5">
                                                            <path
                                                                d="M1.06667 11.7333L0.713112 11.3797L0.566666 11.5262V11.7333H1.06667ZM10.6667 2.1333L11.0202 1.77975C10.9265 1.68598 10.7993 1.6333 10.6667 1.6333C10.5341 1.6333 10.4069 1.68598 10.3131 1.77975L10.6667 2.1333ZM13.8667 5.3333L14.2202 5.68685C14.4155 5.49159 14.4155 5.17501 14.2202 4.97975L13.8667 5.3333ZM4.26667 14.9333V15.4333H4.47377L4.62022 15.2869L4.26667 14.9333ZM1.06667 14.9333H0.566666C0.566666 15.2094 0.790523 15.4333 1.06667 15.4333V14.9333ZM1.42022 12.0869L11.0202 2.48685L10.3131 1.77975L0.713112 11.3797L1.42022 12.0869ZM10.3131 2.48685L13.5131 5.68685L14.2202 4.97975L11.0202 1.77975L10.3131 2.48685ZM13.5131 4.97975L3.91311 14.5797L4.62022 15.2869L14.2202 5.68685L13.5131 4.97975ZM4.26667 14.4333H1.06667V15.4333H4.26667V14.4333ZM1.56667 14.9333V11.7333H0.566666V14.9333H1.56667ZM9.06667 15.4333H15.9998V14.4333H9.06667V15.4333Z"
                                                                fill="#05061E"/>
                                                        </g>
                                                    </svg>
                                                </button>
                                                <button class="table-buttons">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <g opacity="0.5">
                                                            <path
                                                                d="M5.25714 3.32143V1.92857C5.25714 1.41574 5.66648 1 6.17143 1H9.82857C10.3335 1 10.7429 1.41574 10.7429 1.92857V3.32143M1 3.78571H15M3.37143 3.78571V13.0714C3.37143 13.5843 3.78077 14 4.28571 14H11.7143C12.2192 14 12.6286 13.5843 12.6286 13.0714V3.78571M8 6.62958V10.2277V11.4175"
                                                                stroke="#05061E"/>
                                                        </g>
                                                    </svg>
                                                </button>
                                                <button class="table-buttons">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <g opacity="0.5">
                                                            <path
                                                                d="M15 2L15.454 2.20953C15.5397 2.02378 15.5036 1.80455 15.3629 1.65606C15.2222 1.50757 15.0052 1.45979 14.8151 1.53544L15 2ZM1 7.57143L0.815122 7.10686C0.635786 7.17823 0.513544 7.34645 0.501049 7.53906C0.488554 7.73167 0.588037 7.91427 0.756649 8.00821L1 7.57143ZM9 15L8.58004 15.2714C8.67898 15.4245 8.85343 15.5116 9.03528 15.4988C9.21714 15.4859 9.37758 15.3751 9.45398 15.2095L9 15ZM14.8151 1.53544L0.815122 7.10686L1.18488 8.03599L15.1849 2.46456L14.8151 1.53544ZM0.756649 8.00821L5.75665 10.7939L6.24335 9.92036L1.24335 7.13464L0.756649 8.00821ZM5.58004 10.6285L8.58004 15.2714L9.41996 14.7286L6.41996 10.0858L5.58004 10.6285ZM9.45398 15.2095L15.454 2.20953L14.546 1.79047L8.54602 14.7905L9.45398 15.2095ZM14.6598 1.6336L5.65977 9.99075L6.34023 10.7235L15.3402 2.3664L14.6598 1.6336Z"
                                                                fill="#0B0B18"/>
                                                        </g>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                        {{--                                        @foreach($item->detail as $detail)--}}
                                        {{--                                            <td>{{$detail->product->title}}</td>--}}
                                        {{--                                            <td>{{$detail->quantity}}</td>--}}
                                        {{--                                            <td>{{$detail->product->shelf->name ?? 'Seçilməyib'}}</td>--}}
                                        {{--                                            <td>{{$detail->price}}</td>--}}
                                        {{--                                            <td>{{$detail->discount}}</td>--}}
                                        {{--                                            <td>{{$detail->parentStatus->title}}</td>--}}
                                        {{--                                        @endforeach--}}
                                    </tr>
                                @empty

                                @endforelse
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="page-options">
                <div class="page-options-content">
                        <span class="page-op-span f-size-14 c-black-op-75">
                            Hər səhifədə nəticə sayı
                        </span>
                    <div class="dropdown">
                        <div class="dropdown-header">
                                 <span class="f-size-14 c-black-op-50">
                                    {{$orders->perPage()}}
                                 </span>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <g opacity="0.5">
                                    <path d="M4.79999 6.93335L7.99999 10.1333L11.2 6.93335" stroke="#0B0B18"
                                          stroke-linecap="square"/>
                                </g>
                            </svg>
                        </div>
                        <ul class="dropdown-body">
                            @foreach(config('app.limits') as $limit)
                                <li>
                                    <a href="{{request()->fullUrlWithQuery(['limit' => $limit])}}">
                                        {{$limit}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                {{$orders->appends(request()->except('page'))->links('partials.simple-pagination')}}
            </div>
        </div>
    </div>
    {{--  Modals  --}}
    <div class="popup popup-showDetail">
        <div class="layer-popup"></div>
        <div class="popup-container">
            <div class="popup-content popup-success">
                <div class="content">
                </div>

                <div class="pop-buttons">
                    <button class="popup-close pop-button pop-default-button">
                        Bağla
                    </button>
                </div>
            </div>
        </div>
    </div>
    @if($adminRole)
        <div class="popup popup-status">
            <div class="layer-popup"></div>
            <div class="popup-container">
                <div class="popup-content">
                    <form action="{{route('orders.updateOrderDetailStatus')}}" method="post" id="statuschangeform">
                        <div class="news-address-content-inputs mb1">
                            @csrf
                            <label for="" class="label-class f-size-14-b c-dblack-op-75 mb-12">
                                Status
                            </label>
                            <input type="hidden" class="input-class detailId" name="order_detail_id">
                            <div>
                                <select class="input-class statuses" name="status" id="st1">
                                    @foreach($orderStatuses as $status)
                                        <option value="{{$status->id}}">{{$status->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <br>
                            <span class="error-title ors1" style="color: red"></span>
                            <div id="only_kuryer" style="display: none">
                                <div>
                                    <select class="input-class" name="kuryer_id" id="kru1">
                                        <option value="">Select Kuryer</option>
                                        @foreach($kuryers as $kuryer)
                                            <option value="{{$kuryer->id}}"
                                                    class="ks{!!$kuryer->id!!}">{{$kuryer->full_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="error-title kry1" style="color: red"></span><br>
                                {{--                                <div>--}}
                                {{--                                    <select class="input-class" name="kuryer_status" id="krus1">--}}
                                {{--                                        <option value="">Select Kuryer Status</option>--}}
                                {{--                                        @foreach(\App\Models\Order::ORDER_KURYER_STATUSES as $key=>$value)--}}
                                {{--                                            <option value="{{$key}}" class="kstr{!! $key !!}">{{$value}}</option>--}}
                                {{--                                        @endforeach--}}
                                {{--                                    </select>--}}
                                {{--                                </div>--}}
                                <span class="error-title krys1" style="color: red"></span><br>

                                <input type="number" class="input-class krac" name="kuryer_amount"
                                       placeholder="Kuryerin bu Sifarisden qazanci"><br>
                                <span class="error-title kra2"
                                      style="color: red"></span><br>
                                {{--                                <input type="text" class="input-class" name="note" placeholder="Note"--}}
                                {{--                                       id="note_input"><br>--}}
                            </div>
                            <span class="cnk1" style="background: red;color: whitesmoke"></span>
                            <div class="only_reject" style="display: none">
                                <div>
                                    <select class="input-class" name="reason_id2">
                                        <option value="">Select Reason</option>
                                        @foreach(\App\Models\Order::ORDER_REJECT_STATUSES as $key=>$value)
                                            <option value="{{$key}}"
                                                    class="rj{!!$key!!}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="only_cancel" style="display: none">
                                <div>
                                    <select class="input-class" name="reason_id1">
                                        <option value="">Select Reason</option>
                                        @foreach(\App\Models\Order::ORDER_CANCEL_STATUSES as $key=>$value)
                                            <option value="{{$key}}"
                                                    class="cn{!!$key!!}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="only_refund" style="display: none">
                                <div>
                                    <select class="input-class" name="reason_id3">
                                        <option value="">Select Reason</option>
                                        @foreach(\App\Models\Order::ORDER_REFUND_STATUSES as $key=>$value)
                                            <option value="{{$key}}"
                                                    class="rf{!!$key!!}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="pop-buttons px-0">
                            <a href="javascript:void(0)" class="popup-close pop-button pop-default-button">
                                Bağla
                            </a>
                            <button type="submit" class="pop-button pop-dblue-button">
                                Yadda saxla
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @elseif($courierRole)
        <div class="popup popup-status">
            <div class="layer-popup"></div>
            <div class="popup-container">
                <div class="popup-content">
                    <form action="{{route('orders.updateOrderDetailStatus')}}" method="post" id="kuryerForm">
                        <div class="news-address-content-inputs mb1">
                            @csrf
                            <label for="" class="label-class f-size-14-b c-dblack-op-75 mb-12">
                                Status
                            </label>
                            <div>
                                <select class="input-class statuses" name="status" id="st1">
                                    @foreach ($orderStatuses as $status)
                                        @if(in_array($status->id,[3,4,7]))
                                            <option value="{{ $status->id }}">{{ $status->title }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <br>
                            <input type="hidden" class="input-class detailId" name="order_detail_id">
                            <div class="krty1">
                                <label for="" class="label-class f-size-14-b c-dblack-op-75 mb-12">
                                    Kuryer Status
                                </label>
                                <div>
                                    <select class="input-class" name="kuryer_status" id="krus1">
                                        @foreach(\App\Models\Order::ORDER_KURYER_STATUSES as $key=>$value)
                                            <option value="{{$key}}" class="kstr{!! $key !!}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <input type="text" class="input-class" name="note" placeholder="Note"
                                       id="note_input"><br>
                            </div>
                            <br>
                            <span class="error-title krys1" style="color: red"></span><br>

                            <span class="cnk1" style="background: red;color: whitesmoke"></span>
                            <div class="only_refund" style="display: none">
                                <div>
                                    <select class="input-class" name="reason_id3">
                                        <option value="">Select Reason</option>
                                        @foreach(\App\Models\Order::ORDER_REFUND_STATUSES as $key=>$value)
                                            <option value="{{$key}}"
                                                    class="rf{!!$key!!}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="pop-buttons px-0">
                            <a href="javascript:void(0)" class="popup-close pop-button pop-default-button">
                                Bağla
                            </a>
                            <button type="submit" class="pop-button pop-dblue-button">
                                Yadda saxla
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @elseif($sellerRole)
        <div class="popup popup-status">
            <div class="layer-popup"></div>
            <div class="popup-container">
                <div class="popup-content">
                    <form action="{{route('orders.updateOrderDetailStatus')}}" method="post" id="magazaForm">
                        <div class="news-address-content-inputs mb1">
                            @csrf
                            <span class="error-title krys1" style="color: red"></span><br>
                            <label for="" class="label-class f-size-14-b c-dblack-op-75 mb-12">
                                Magaza Status
                            </label>
                            <input type="hidden" class="input-class detailId" name="order_detail_id">
                            <div>
                                <select class="input-class" name="seller_status" id="krus2">
                                    <option value="">Select Status</option>
                                    @foreach(\App\Models\Order::ORDER_SELLER_STATUSES as $key=>$value)
                                        <option value="{{$key}}" class="kstr2{!! $key !!}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pop-buttons px-0">
                            <a href="javascript:void(0)" class="popup-close pop-button pop-default-button">
                                Bağla
                            </a>
                            <button type="submit" class="pop-button pop-dblue-button">
                                Yadda saxla
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    <div class="popup popup-delete">
        <div class="layer-popup"></div>
        <div class="popup-container">
            <form action="" id="deleteForm" class="hidden" method="post">
                <div class="popup-content">
                    <div class="popup-header bor-bottom-black-1">
                        <h6>
                            Əminsiniz?
                        </h6>
                    </div>
                    <p class="pop-p">
                        Seçdiyiniz məlumat silinəcək və məlumat geri qaytarıla bilməz
                    </p>
                    <div class="pop-buttons">
                        @csrf
                        @method('DELETE')
                        <a href="javascript:void(0)" class="popup-close pop-button pop-gray-button">
                            Bağla
                        </a>
                        <button type="submit" class="pop-button pop-dblue-button">
                            Bəli, sil
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
@push('js')
    <script>
        // jQuery.noConflict();
        {{--        @if($order_status!=3)--}}
        {{--        $("#only_kuryer").hide();--}}
        {{--        @endif--}}
        $('.showDetail').on('click', function () {
            console.log("Kamil")
            var url = $(this).attr('data-url');
            $(".popup-showDetail").addClass("active");
            $(".popup-showDetail .content").append('<p class="pop-p">Yüklənir</p>');
            $("body").addClass("active");
            $.get(url, function (result) {
                $(".popup-showDetail .content").html('')
                $(".popup-showDetail .content").append(result);
            })
        });

        $('.changeStatus').on('click', function () {
            var orderDetail = $(this).attr('data-orderdetail');
            var orderDetailStatus = $(this).attr('data-status');
            var kuryer_id = $(this).attr('data-kuryer_id');
            var kuryer_status = $(this).attr('data-kuryer_status_id');
            var kuryer_odenis = $(this).attr('data-kuryer_odenis');
            var kuryer_note = $(this).attr('data-kuryer_note');
            var reason_id = $(this).attr('data-reason_id');
            var kuryer_reason_id = $(this).attr('data-kuryer_reason_id');
            var seller_status = $(this).attr('data-seller_status');
            if (orderDetailStatus == 3) {
                $("#only_kuryer").show();
            } else {
                $("#only_kuryer").hide();
            }
            if (orderDetailStatus == 5) {
                if (reason_id) {
                    $('.cn' + reason_id).prop('selected', true)
                }
                $(".only_cancel").show();
            } else {
                $(".only_cancel").hide();
            }
            if (orderDetailStatus == 6) {
                if (reason_id) {
                    $('.rj' + reason_id).prop('selected', true)
                }
                $(".only_reject").show();
            } else {
                $(".only_reject").hide();
            }
            if (orderDetailStatus == 7) {
                if (reason_id) {
                    $('.rf' + reason_id).prop('selected', true)
                }
                $(".only_refund").show();
            } else {
                $(".only_refund").hide();
            }
            if (kuryer_status == 4) {
                if (kuryer_reason_id) {
                    $('.rf' + kuryer_reason_id).prop('selected', true)
                }
                $(".only_refund").show();
            }
            if (seller_status) {
                $('.kstr2' + seller_status).prop('selected', true)
            }
            $(".statuses").val(orderDetailStatus);
            $(".detailId").val(orderDetail);
            $(".krac").val(kuryer_odenis);
            $("#note_input").val(kuryer_note);
            $(".popup-status").addClass("active");
            $(".ks" + kuryer_id).attr("selected", "selected");
            $(".kstr" + kuryer_status).attr("selected", "selected");
            $("body").addClass("active");
        })

        $('.deleteDetail').on('click', function () {
            var url = $(this).attr('data-url');
            $('#deleteForm').attr('action', url);
            $(".popup-delete").addClass("active");
            $("body").addClass("active");
        });

        {{--$('.productStockCount').on('change', function () {--}}
        {{--    var item = $(this).attr('data-item');--}}
        {{--    $.post("{{route('orders.stock')}}", {type: 'order', id: item}, function (result) {--}}
        {{--        successSave()--}}
        {{--    })--}}
        {{--})--}}

        $('.statuses').on('change', function () {
            var reason_id = $(this).attr('data-reason_id');
            if (this.value == 3) {
                $("#only_kuryer").show();
                $(".krty1").show();
            } else {
                $("#only_kuryer").hide();
                $(".krty1").hide();
            }
            if (this.value == 5) {
                if (reason_id) {
                    $('.cn' + reason_id).prop('selected', true)
                }
                $(".only_cancel").show();
            } else {
                $(".only_cancel").hide();
            }
            if (this.value == 6) {
                if (reason_id) {
                    $('.rj' + reason_id).prop('selected', true)
                }
                $(".only_reject").show();
            } else {
                $(".only_reject").hide();
            }
            if (this.value == 7) {
                if (reason_id) {
                    $('.rf' + reason_id).prop('selected', true)
                }
                $(".only_refund").show();
            } else {
                $(".only_refund").hide();
            }
            // console.log(this.value)
        })
        $("#statuschangeform").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(form[0]);
            // let deliverySaveBtn = form.find("#submitBtn");
            // deliverySaveBtn.html('Gözləyin');
            // deliverySaveBtn.attr('disabled', true);
            fetch(form.attr('action'), {
                method: form.attr('method'),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'accept': 'application/json',
                },
                body: formData,
            })
                .then(response => response.json())
                .then(function (response) {
                    console.log(response)
                    console.log("K")
                    if (response.success) {
                        $(".popup-address").removeClass("active");
                        $("body").removeClass("active");
                        location.reload();
                    } else {
                        if (response.errors.hasOwnProperty('status')) {
                            $('.ors1').show();
                            $('.ors1').text(response.errors.status[0]);
                            $('#st1').addClass('error-input');
                        } else {
                            $('.ors1').hide();
                            $('#st1').removeClass('error-input');
                        }
                        if (response.errors.hasOwnProperty('kuryer_id')) {
                            $('.kry1').show();
                            $('.kry1').text(response.errors.kuryer_id[0]);
                            $('#kru1').addClass('error-input');
                        } else {
                            $('.kry1').hide();
                            $('#kru1').removeClass('error-input');
                        }
                        if (response.errors.hasOwnProperty('kuryer_amount')) {
                            $('.kra2').show();
                            $('.kra2').text(response.errors.kuryer_amount[0]);
                            $('.krac').addClass('error-input');
                        } else {
                            $('.kra2').hide();
                            $('.krac').removeClass('error-input');
                        }
                        if (response.errors.hasOwnProperty('kuryer_status')) {
                            $('.krys1').show();
                            $('.krys1').text(response.errors.kuryer_status[0]);
                            $('#krus1').addClass('error-input');
                        } else {
                            $('.krys1').hide();
                            $('#krus1').removeClass('error-input');
                        }
                        if (response.errors.hasOwnProperty('reason_id')) {
                            $('.cnk1').show();
                            $('.cnk1').text(response.errors.reason_id[0]);
                        } else {
                            $('.cnk1').hide();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error');
                    console.log(error)
                });
            // deliverySaveBtn.attr('disabled', false);
            // deliverySaveBtn.html('Yadda saxla');
            // $("#menu-add-delivery").removeClass('active');
            return false;
        });
        $("#kuryerForm").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(form[0]);
            fetch(form.attr('action'), {
                method: form.attr('method'),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'accept': 'application/json',
                },
                body: formData,
            })
                .then(response => response.json())
                .then(function (response) {
                    console.log(response)
                    console.log("K")
                    if (response.success) {
                        $(".popup-address").removeClass("active");
                        $("body").removeClass("active");
                        location.reload();
                    } else {
                        if (response.errors.hasOwnProperty('status')) {
                            $('.ors1').show();
                            $('.ors1').text(response.errors.status[0]);
                            $('#st1').addClass('error-input');
                        } else {
                            $('.ors1').hide();
                            $('#st1').removeClass('error-input');
                        }
                        if (response.errors.hasOwnProperty('kuryer_id')) {
                            $('.kry1').show();
                            $('.kry1').text(response.errors.kuryer_id[0]);
                            $('#kru1').addClass('error-input');
                        } else {
                            $('.kry1').hide();
                            $('#kru1').removeClass('error-input');
                        }
                        if (response.errors.hasOwnProperty('kuryer_amount')) {
                            $('.kra2').show();
                            $('.kra2').text(response.errors.kuryer_amount[0]);
                            $('.krac').addClass('error-input');
                        } else {
                            $('.kra2').hide();
                            $('.krac').removeClass('error-input');
                        }
                        if (response.errors.hasOwnProperty('kuryer_status')) {
                            $('.krys1').show();
                            $('.krys1').text(response.errors.kuryer_status[0]);
                            $('#krus1').addClass('error-input');
                        } else {
                            $('.krys1').hide();
                            $('#krus1').removeClass('error-input');
                        }
                        if (response.errors.hasOwnProperty('reason_id')) {
                            $('.cnk1').show();
                            $('.cnk1').text(response.errors.reason_id[0]);
                        } else {
                            $('.cnk1').hide();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error');
                    console.log(error)
                });
            // deliverySaveBtn.attr('disabled', false);
            // deliverySaveBtn.html('Yadda saxla');
            // $("#menu-add-delivery").removeClass('active');
            return false;
        });
        $("#magazaForm").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(form[0]);
            fetch(form.attr('action'), {
                method: form.attr('method'),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'accept': 'application/json',
                },
                body: formData,
            })
                .then(response => response.json())
                .then(function (response) {
                    console.log(response)
                    console.log("K")
                    if (response.success) {
                        $(".popup-address").removeClass("active");
                        $("body").removeClass("active");
                        location.reload();
                    } else {
                        if (response.errors.hasOwnProperty('status')) {
                            $('.ors1').show();
                            $('.ors1').text(response.errors.status[0]);
                            $('#st1').addClass('error-input');
                        } else {
                            $('.ors1').hide();
                            $('#st1').removeClass('error-input');
                        }
                        if (response.errors.hasOwnProperty('reason_id')) {
                            $('.cnk1').show();
                            $('.cnk1').text(response.errors.reason_id[0]);
                        } else {
                            $('.cnk1').hide();
                        }
                        if (response.errors.hasOwnProperty('seller_status')) {
                            $('.krys1').show();
                            $('.krys1').text(response.errors.seller_status[0]);
                        } else {
                            $('.krys1').hide();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error');
                    console.log(error)
                });
            // deliverySaveBtn.attr('disabled', false);
            // deliverySaveBtn.html('Yadda saxla');
            // $("#menu-add-delivery").removeClass('active');
            return false;
        });
    </script>
@endpush
