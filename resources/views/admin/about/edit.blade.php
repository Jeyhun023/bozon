@extends('layouts.app',['title'=>'Haqqimizda Redacte et'])
@section('body_class','add-product')

@section('breadcrump')
    <div class="top-section b-black">
        <div class="container">
            <div class="top-section-inner">
                <div>
                    <div class="page-links">
                        <a href="/v2" class="c-white-op-75 f-size-14">Ana səhifə > </a>
                        <a href="{{route('about.edit')}}" class="c-white-op-75 f-size-14">&emsp14;About</a>
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
            <form action="{{route('about.update')}}" method="post"
                  enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="xl-2">
                    </div>
                    <div class="xl-9">
                        <div class="new-address-content bradius-8 b-white">
                            <div class="new-address-content-header bor-bottom-black-1">
                                <span class="f-size-16">
                                    About Redakte et
                                </span>
                            </div>
                            <div class="new-address-content-body">
                                <div class="new-address-content-input-groups">
                                    <div class="news-address-content-inputs">
                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                            Title 1
                                        </label>
                                        <input type="text" class="input-class" name="title1"
                                               value="{{old('title1',$about->title1)}}">
                                    </div>
                                </div>
                                <div class="new-address-content-input-groups">
                                    <div class="news-address-content-inputs">
                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                            Title 2
                                        </label>
                                        <input type="text" class="input-class" name="title2"
                                               value="{{old('title2',$about->title2)}}">
                                    </div>
                                </div>
                                <div class="new-address-content-input-groups">
                                    <div class="news-address-content-inputs">
                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                            Title 3
                                        </label>
                                        <input type="text" class="input-class" name="title3"
                                               value="{{old('title3',$about->title3)}}">
                                    </div>
                                </div>
                                <div class="new-address-content-input-groups">
                                    <div class="news-address-content-inputs">
                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                            View Text
                                        </label>
                                        <textarea name="view_text" class="input-class">{!! old('view_text',$about->view_text) !!}</textarea>
                                    </div>
                                </div>
                                <div class="new-address-content-input-groups">
                                    <div class="news-address-content-inputs">
                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                            Mission Text
                                        </label>
                                        <textarea name="mission_text" class="input-class">{!! old('mission_text',$about->mission_text) !!}</textarea>
                                    </div>
                                </div>
                                <button type="submit" class="new-address-button">
                                    Yadda saxla
                                </button>
                            </div>
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
