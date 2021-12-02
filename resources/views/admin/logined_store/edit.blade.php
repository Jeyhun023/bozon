@extends('layouts.app',['title'=>'Magazalar Redacte et'])
@section('body_class','add-product')

@section('breadcrump')
    <div class="top-section b-black">
        <div class="container">
            <div class="top-section-inner">
                <div>
                    <div class="page-links">
                        <a href="/v2" class="c-white-op-75 f-size-14">Ana səhifə > </a>
                        <a href="{{route('magazas.index')}}" class="c-white-op-75 f-size-14">&emsp14;Magazalar</a>
                        <span class="c-white-op-50 f-size-14">
                                Redaktə et
                            </span>
                    </div>
                    <h6 class="f-size-24 c-white">
                        Redaktə et
                    </h6>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="add-product-page b-white-1">
        <div class="container">
            @if($errors->any())
                <div style="background: red;color: white;font-size: 12px;border-radius: 4%" id="roles_create_error">
                    <ul style="margin-left: 5px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @isset($danger)
                <h3 style="background: red;color:white">{{$danger}}</h3>
            @endisset
            <form action="{{route('logined.store.update',['store' => $store->id])}}" method="post"
                  enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <input type="hidden" name="id" value="{{$store->id}}">
                <div class="row">
                    <div class="xl-2">
                    </div>
                    <div class="xl-9">
                        <div class="new-address-content bradius-8 b-white">
                            <div class="new-address-content-header bor-bottom-black-1">
                                <span class="f-size-16">
                                    Magazani Redakte et
                                </span>
                            </div>
                            <div class="new-address-content-body">
                                <div class="new-address-content-input-groups">
                                    <div class="news-address-content-inputs">
                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                            Full name
                                        </label>
                                        <input type="text" class="input-class" name="full_name"
                                               value="{{old('full_name',$store->full_name)}}">
                                    </div>
                                </div>
                                <div class="new-address-content-input-groups">
                                    <div class="news-address-content-inputs">
                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                            Category
                                        </label>
                                        <select name="category_id" class="input-class">
                                            <option value="">Select Category</option>
                                            @foreach($category as $item)
                                                <option value="{{$item->id}}"
                                                        @if($store->category)  @if($item->id == $store->category->id) selected @endif @endif>{!! $item->name !!}</option>
                                                @if(count($item->children2))
                                                    @include('admin.logined_store.child_option_edit',['items' => $item->children2,'prefix'=>'&nbsp;&nbsp;'])
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="new-address-content-input-groups">
                                    <div class="news-address-content-inputs">
                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                            Url
                                        </label>
                                        <input type="text" class="input-class" name="url"
                                               value="{{old('url',$store->url)}}">
                                    </div>
                                </div>
                                {{--                                <div class="new-address-content-input-groups">--}}
                                {{--                                    <div class="news-address-content-inputs">--}}
                                {{--                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">--}}
                                {{--                                            Username--}}
                                {{--                                        </label>--}}
                                {{--                                        <input type="text" class="input-class" name="username"--}}
                                {{--                                               value="{{old('username',$store->userdetail->email)}}">--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                                {{--                                <div class="new-address-content-input-groups">--}}
                                {{--                                    <div class="news-address-content-inputs">--}}
                                {{--                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">--}}
                                {{--                                            Password--}}
                                {{--                                        </label>--}}
                                {{--                                        <input type="password" class="input-class" name="password">--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                                {{--                                <div class="new-address-content-input-groups">--}}
                                {{--                                    <div class="news-address-content-inputs">--}}
                                {{--                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">--}}
                                {{--                                            Repeat Password--}}
                                {{--                                        </label>--}}
                                {{--                                        <input type="password" class="input-class" name="password_confirmation">--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                                <div class="new-address-content-input-groups">
                                    <div class="news-address-content-inputs">
                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                            ThumbNail
                                        </label>
                                        <input type="file" class="input-class" name="thumb_nail">
                                    </div>
                                    <div class="news-address-content-inputs">
                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                            Logo
                                        </label>
                                        <input type="file" class="input-class" name="logo">
                                    </div>
                                    <div class="news-address-content-inputs">
                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                            Status
                                        </label>
                                        <label for="b">
                                            <div class="private f-size-14-b c-dblack-75">
                                                Aktivdir
                                                <div class="checkboxes">
                                                    <div class="check">
                                                        <input type="checkbox" name="active" id="b"
                                                               @if(old('active',$store->active)) checked @endif>
                                                        <label for="b"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="new-address-content-input-groups">
                                    <div class="news-address-content-inputs">
                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                            Haqqında
                                        </label>
                                        <textarea class="mytextarea"
                                                  name="about">{!! old('about',$store->about) !!}</textarea>
                                    </div>
                                </div>
                                <button type="submit" class="new-address-button">
                                    Yadda saxla
                                </button>
                            </div>
                            <img src="{{asset('/uploads/magazas/'.$store->thumb_nail)}}" alt="">
                            <img src="{{asset('/uploads/magazas/'.$store->logo)}}" alt="">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        @if(session()->has('success'))
        @if(session()->get('success'))
        $('.popup-3').addClass('active');
        @endif
        @endif
    </script>
@endsection
