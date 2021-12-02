@extends('layouts.app',['title'=>"Products"])
@section('breadcrump')
    <div class="top-section b-black">
        <div class="container">
            <div class="top-section-inner">
                <div>
                    <div class="page-links">
                        <a href="/v2" class="c-white-op-75 f-size-14">Ana səhifə</a>
                        <span class="c-white-op-50 f-size-14">
                                Məhsullar
                            </span>
                    </div>
                    <h6 class="f-size-24 c-white">
                        Məhsullar
                    </h6>
                </div>
                <a href="{{ route('admin.products.create') }}" class="button-blue f-size-14 c-white bradius-4  b-blue">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 1.06665V14.9333M1.06667 7.99998H14.9333" stroke="white"/>
                    </svg>
                    Yenisini əlavə et
                </a>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="homepage-content b-white-1">
        <div class="search-result-parent">
            <div class="container">
                <div class="search-result">
                    <div class="search-result-header">
                            <span class="f-size-14 search-esult-span c-dblack-75">
                                {{$products->total()}} nəticə
                            </span>
{{--                        <button class="delete-search-result"--}}
{{--                                onclick="deletepop40('{!! route('banner.deleteSelections') !!}','ff')">--}}
{{--                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"--}}
{{--                                 xmlns="http://www.w3.org/2000/svg">--}}
{{--                                <g>--}}
{{--                                    <path--}}
{{--                                        d="M5.25714 3.32143V1.92857C5.25714 1.41574 5.66648 1 6.17143 1H9.82857C10.3335 1 10.7429 1.41574 10.7429 1.92857V3.32143M1 3.78571H15M3.37143 3.78571V13.0714C3.37143 13.5843 3.78077 14 4.28571 14H11.7143C12.2192 14 12.6286 13.5843 12.6286 13.0714V3.78571M8 6.62958V10.2277V11.4175"--}}
{{--                                        stroke="#05061E"/>--}}
{{--                                </g>--}}
{{--                            </svg>--}}
{{--                            <span class="f-size-14">--}}
{{--                                    Sil--}}
{{--                                </span>--}}
{{--                        </button>--}}
                    </div>
                    <div class="search-result-body">
                        <div class="table-content-overflow">
                            <table class="search-result-table-overflow search-result-table">
                                <tr>
{{--                                    <th class="search-result-table-th">--}}
{{--                                        <label class="checkbox-parent">--}}
{{--                                            <input type="checkbox" class="checkbox-table sd_all" id="checkParent"--}}
{{--                                                   onclick="sdAll('ff','{!! $products->pluck('id')->implode(',') !!}','.sd_all','.cs1')">--}}
{{--                                            <span class="checkmark"></span>--}}
{{--                                        </label>--}}
{{--                                    </th>--}}
                                    <th>Thumbnail</th>
                                    <th>Başlıq</th>
                                    <th>Rəng</th>
                                    <th>Qiymət</th>
                                    <th>Brend</th>
                                    <th>Stok</th>
                                    <th>Status</th>
                                    <th>Kateqoriya</th>
                                    <th class="right-button-parent">Tənzimləmələr</th>
                                </tr>
                                @foreach($products as $item)
                                    <tr>
{{--                                        <td class="search-result-table-td">--}}
{{--                                            <label class="checkbox-parent">--}}
{{--                                                <input type="checkbox" class="checkbox-table cs1 ds{!! $item->id !!}"--}}
{{--                                                       onclick="checkInput('ff','{!! $item->id !!}','.ds')">--}}
{{--                                                <span class="checkmark"></span>--}}
{{--                                            </label>--}}
{{--                                        </td>--}}
                                        <td><img src="{{ asset('/uploads/products/thumbnails/'.$item->thumbnail)}}"
                                                 alt="Thumb" style="width: 200px;height: 200px"></td>
                                        <td>{{$item->name}}</td>
                                        <td>
                                            @foreach($item->colors as $color)
                                                {{$color->color ? $color->color->name: ''}}{{ !$loop->last ? ',' : ''}}
                                            @endforeach
                                        </td>
                                        <td>{{$item->price}}</td>
                                        <td>{{$item->brand ? $item->brand->name : ''}}</td>
                                        <td>{{$item->qty}}  </td>
                                        <td>
                                            <form action="{{route('admin.product.visible',['product'=>$item->id])}}"
                                                  method="post">
                                                @csrf
                                                @method('PUT')
                                                @if($item->visible)
                                                    <button class="btn btn-danger" type="submit">Click to Deactivate
                                                    </button>
                                                @else
                                                    <button class="btn btn-success" type="submit">Click to Activate
                                                    </button>
                                                @endif
                                            </form>
                                        </td>
                                        <td>{{$item->category ? $item->category->name : ''}}</td>
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
                                                <button class="table-buttons"
                                                        onclick="opendeletePOPUP('{!! route('banners.destroy',['banner'=>$item->id]) !!}')">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <g opacity="0.5">
                                                            <path
                                                                d="M5.25714 3.32143V1.92857C5.25714 1.41574 5.66648 1 6.17143 1H9.82857C10.3335 1 10.7429 1.41574 10.7429 1.92857V3.32143M1 3.78571H15M3.37143 3.78571V13.0714C3.37143 13.5843 3.78077 14 4.28571 14H11.7143C12.2192 14 12.6286 13.5843 12.6286 13.0714V3.78571M8 6.62958V10.2277V11.4175"
                                                                stroke="#05061E"/>
                                                        </g>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
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
                                   {{$products->perPage()}}
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
                {{$products->appends(request()->except('page'))->links('partials.simple-pagination')}}
            </div>
        </div>
    </div>
@endsection
