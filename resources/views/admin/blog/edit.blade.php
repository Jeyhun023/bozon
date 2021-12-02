@extends('layouts.app',['title'=>'Magazalar Redacte et'])
@section('body_class','add-product')

@section('breadcrump')
    <div class="top-section b-black">
        <div class="container">
            <div class="top-section-inner">
                <div>
                    <div class="page-links">
                        <a href="/v2" class="c-white-op-75 f-size-14">Ana səhifə > </a>
                        <a href="{{route('blogs.index')}}" class="c-white-op-75 f-size-14">&emsp14;Blogs</a>
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
            <form action="{{route('blogs.update',['blog' => $blog->id])}}" method="post"
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
                                    Blog Redakte et
                                </span>
                            </div>
                            <div class="new-address-content-body">
                                <div class="new-address-content-input-groups">
                                    <div class="news-address-content-inputs">
                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                           Title
                                        </label>
                                        <input type="text" class="input-class" name="title"
                                               value="{{old('title',$blog->title)}}">
                                    </div>
                                </div>
                                <div class="new-address-content-input-groups">
                                    <div class="news-address-content-inputs">
                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                            Url
                                        </label>
                                        <input type="text" class="input-class" name="url"
                                               value="{{old('url',$blog->url)}}">
                                    </div>
                                </div>
                                <div class="new-address-content-input-groups">
                                    <div class="news-address-content-inputs">
                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                            ThumbNail
                                        </label>
                                        <input type="file" class="input-class" name="thumb_nail">
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
                                                               @if(old('active',$blog->active)) checked @endif>
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
                                                  name="about">{!! old('about',$blog->description) !!}</textarea>
                                    </div>
                                </div>
                                <button type="submit" class="new-address-button">
                                    Yadda saxla
                                </button>
                            </div>

                            <img src="{{asset('/uploads/blogs/'.$blog->thumb_nail)}}" alt="">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
