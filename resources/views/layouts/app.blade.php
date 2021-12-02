<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
    <link rel="stylesheet" href="{{asset('/css/general.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
            integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
            crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <!-- font links -->
    <link rel="stylesheet" href="{{asset('/css/font/stylesheet.css')}}">
    <link rel="stylesheet" href="{{asset('/js/dropzone-5.7.0/dist/min/dropzone.min.css')}}">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/kbs5kau7fahfhmzmcsnxxeo4qduhffqdu58x0ppe3n47jj2z/tinymce/5/tinymce.min.js"
            referrerpolicy="origin"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/3.23.0/tagify.min.css"
          integrity="sha512-SxgrVgd3c/mmDd/98A5HXv/g1RSyvhTS/D7/a3N3kNSRqf1YEM83qyHafYZcfzjoM99ZDGEgDcDBkSpBhKKyJQ=="
          crossorigin="anonymous"/>

    <style>
        .radio-parent {
            display: block;
            position: relative;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .radio-parent input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 1.6rem;
            width: 1.6rem;
            background-color: #eee;
            border-radius: 50%;
            border: 2px solid #eee;
        }


        .radio-parent input:checked ~ .checkmark {
            border: 2px solid #0B0B18;
            background: #fff;
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        .radio-parent input:checked ~ .checkmark:after {
            display: block;
        }

        .radio-parent .checkmark:after {
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            margin: auto;
            width: 1.2rem;
            height: 1.2rem;
            border-radius: 50%;
            background: #0B0B18;
        }
    </style>
</head>

<body>
<div class="homepage">
    @php
        $adminRole = \Illuminate\Support\Facades\Auth::guard('admin_user')->check() ?  (\Illuminate\Support\Facades\Auth::guard('admin_user')->user()->hasRole('admin') ? true : false) : false;
        $courierRole = \Illuminate\Support\Facades\Auth::guard('admin_user')->check() ?  (\Illuminate\Support\Facades\Auth::guard('admin_user')->user()->hasRole('courier') ? true : false) : false;
        $sellerRole = \Illuminate\Support\Facades\Auth::guard('seller')->check() ?  (\Illuminate\Support\Facades\Auth::guard('seller')->user()->hasRole('seller') ? true : false) : false;
    @endphp
    @include('partials.modals')
    <header class="header-top bor-bottom-white-20 b-black-blur">
        <div class="container">
            <div class="row">
                <div class="xl-1">
                    <a href="">
                        <img src="{{asset('/img/united skills.png')}}" class="logo" alt="logo">
                    </a>
                </div>
                <div {!! $sellerRole || $courierRole ? 'class="xl-3"' : 'class="xl-9"'  !!}>
                    <ul class="header-top-ul">
                        @if($adminRole)
                            <li>
                                <a href="{{route('banners.index')}}" class="c-white f-size-14">
                                    Slayder
                                </a>
                            </li>
                            <li>
                                <a href="{{route('category.index')}}" class="c-white f-size-14">
                                    Categories
                                </a>
                            </li>
                            <li>
                                <a href="{{route('clients.index')}}" class="c-white f-size-14">
                                    İstifadəçilər
                                </a>
                            </li>
                            <li>
                                <a href="{{route('appeals.index')}}" class="c-white f-size-14">
                                    Müraciətlər
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin_users.index')}}" class="c-white f-size-14">
                                    Admin Users
                                </a>
                            </li>
                            <li>
                                <a href="{{route('magazas.index')}}" class="c-white f-size-14">
                                    Mağazalar
                                </a>
                            </li>
                        @endif
                        @if($adminRole || $sellerRole)
                            <li>
                                <a href="{{route('seller_users.index')}}" class="c-white f-size-14">
                                    Magaza Users
                                </a>
                            </li>
                            <li>
                                <a href="/v2/admin/products" class="c-white f-size-14">
                                    Məhsullar
                                </a>
                            </li>
                            <li>
                                <a href="/v2/admin/catalogs" class="c-white f-size-14">
                                    Kataloq
                                </a>
                            </li>
                        @endif
                        @if($adminRole)
                            <li>
                                <a href="{{route('cities.index')}}" class="c-white f-size-14">
                                    Ərazilər
                                </a>
                            </li>
                            <li>
                                <a href="{{route('blogs.index')}}" class="c-white f-size-14">
                                    Bloqlar
                                </a>
                            </li>
                            <li>
                                <a href="{{route('vacancies.index')}}" class="c-white f-size-14">
                                    Vakansiyalar
                                </a>
                            </li>
                            <li>
                                <a href="{{route('about.edit')}}" class="c-white f-size-14">
                                    Haqqimizda
                                </a>
                            </li>
                            <li>
                                <a href="{{route('con.index')}}" class="c-white f-size-14">
                                    Müştəri Xidmətləri
                                </a>
                            </li>
                        @endif
                        @if($sellerRole || $courierRole || $adminRole)
                            <li>
                                <a href="{{route('orders.index')}}" class="c-white f-size-14">
                                    Sifarişlər
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
                <div {!! $sellerRole||$courierRole ? 'class="xl-8"' : 'class="xl-3"'  !!}>
                    <div class="header-account">
                        @if($sellerRole)
                            <a href="{{route('logined.store.edit',['store'=>\Illuminate\Support\Facades\Auth::guard('seller')->user()->seller_id])}}"
                               class="header-top-account c-white f-size-14">
                                Hesab
                            </a>
                        @endif
                        <form action="{{route('admin.logout')}}" method="post">
                            @csrf
                            <button type="submit" style="font-size: 16px;
    background: transparent;
    color: white;">Logout
                            </button>
                        </form>
                        {{--                        <a href="" class="header-top-edit bor-left-white-20">--}}
                        {{--                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"--}}
                        {{--                                 xmlns="http://www.w3.org/2000/svg">--}}
                        {{--                                <path fill-rule="evenodd" clip-rule="evenodd"--}}
                        {{--                                      d="M6.34027 0.533447L6.24853 0.999268L5.89761 2.70376C5.33654 2.91802 4.82773 3.22185 4.368 3.58215L2.6528 3.00864L2.19201 2.8658L1.95308 3.27726L0.772265 5.25142L0.533333 5.66294L0.883203 5.96886L2.21014 7.0977C2.16214 7.39298 2.10028 7.68503 2.10028 7.99523C2.10028 8.30543 2.16214 8.59755 2.21014 8.89282L0.883203 10.0217L0.533333 10.3276L0.772265 10.739L1.95308 12.7133L2.19201 13.1258L2.6528 12.9819L4.368 12.4084C4.82773 12.7687 5.33654 13.0724 5.89761 13.2867L6.24853 14.9912L6.34027 15.4571H9.65867L9.75146 14.9912L10.1013 13.2867C10.6624 13.0724 11.1712 12.7687 11.6309 12.4084L13.3461 12.9819L13.8069 13.1258L14.0469 12.7133L15.2267 10.739L15.4667 10.3276L15.1157 10.0217L13.7888 8.89282C13.8379 8.59755 13.8987 8.30543 13.8987 7.99523C13.8987 7.68503 13.8379 7.39298 13.7888 7.0977L15.1157 5.96886L15.4667 5.66294L15.2267 5.25142L14.0469 3.27726L13.8069 2.8658L13.3461 3.00864L11.6309 3.58215C11.1712 3.22185 10.6624 2.91802 10.1013 2.70376L9.75146 0.999268L9.65867 0.533447H6.34027Z"--}}
                        {{--                                      stroke="white" stroke-linecap="square" stroke-linejoin="round"/>--}}
                        {{--                                <path fill-rule="evenodd" clip-rule="evenodd"--}}
                        {{--                                      d="M10.1329 7.99523C10.1329 9.17206 9.17721 10.1272 7.99961 10.1272C6.82201 10.1272 5.86628 9.17206 5.86628 7.99523C5.86628 6.8184 6.82201 5.86333 7.99961 5.86333C9.17721 5.86333 10.1329 6.8184 10.1329 7.99523Z"--}}
                        {{--                                      stroke="white" stroke-linecap="square" stroke-linejoin="round"/>--}}
                        {{--                            </svg>--}}
                        {{--                        </a>--}}
                    </div>
                </div>
            </div>
        </div>
    </header>
    @yield('breadcrump')
    @yield('content')
    <footer>
        <div class="container">
            <div class="footer-content">
                <span class="f-size-14 c-black-op-75">All rights reserved. © 2021</span>
                <div class="footer-logo">
                        <span class="f-size-14 c-black-op-75">
                            Developed by
                        </span>
                    <a href="">
                        <img src="{{asset('/img/united skills.png')}}" class="logo" alt="logo">
                    </a>
                </div>
            </div>
        </div>
    </footer>
</div>

<script src="{{asset('/js/main.js')}}"></script>
<script src="{{asset('/js/dropzone-5.7.0/dist/dropzone.js')}}"></script>
<script src="{{asset('/js/for_ajax.js')}}"></script>
<script src="{{asset('/js/tagify.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/3.23.0/jQuery.tagify.min.js"
        integrity="sha512-zbSfMeVMs6cYwIfH9Npi0KWaPwAI6qXFMhiIZDQcHZA6zV4huHwSeLasJXGocv/JHAZgdLSo6h1isH+EbRaOUA=="
        crossorigin="anonymous"></script>
@stack('js')
</body>

</html>
