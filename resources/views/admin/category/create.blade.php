@extends('layouts.app',['title'=>"Categories"])

@section('breadcrump')
    <div class="top-section b-black">
        <div class="container">
            <div class="top-section-inner">
                <div>
                    <div class="page-links">
                        <a class="c-white-op-75 f-size-14">Ana səhifə > </a>
                        <a href="{{route('category.index')}}" class="c-white-op-75 f-size-14">&emsp14;Categories</a>
                        <span class="c-white-op-50 f-size-14">
                                Yenisini əlavə et
                            </span>
                    </div>
                    <h6 class="f-size-24 c-white">
                        Yenisini əlavə et
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
            @if(session()->has('danger'))
                <h3 style="background: red;color:white">{{session()->get('danger')}}</h3>
            @endisset
            <form action="{{route('category.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="xl-2">
                    </div>
                    <div class="xl-9">
                        <div class="new-address-content bradius-8 b-white">
                            <div class="new-address-content-header bor-bottom-black-1">
                                <span class="f-size-16">
                                    Category Elave et
                                </span>
                            </div>
                            <div class="new-address-content-body">
                                <div class="new-address-content-input-groups">
                                    <div class="news-address-content-inputs">
                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                            Parent Category
                                        </label>
                                        <select name="parent_id" class="input-class">
                                            <option value="0">Select Category</option>
                                            @foreach($category as $item)
                                                <option value="{{$item->id}}">{!! $item->name !!}</option>
                                                @if(count($item->children2))
                                                    @include('admin.category.child_option',['items' => $item->children2,'prefix'=>'&nbsp;&nbsp;'])
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="new-address-content-input-groups">
                                    <div class="news-address-content-inputs">
                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                            Name
                                        </label>
                                        <input type="text" class="input-class" name="name"
                                               value="{{old('name')}}">
                                    </div>
                                </div>
                                <div class="new-address-content-input-groups">
                                    <div class="news-address-content-inputs">
                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                            Sort
                                        </label>
                                        <input type="number" class="input-class" name="sort" value="{{old('sort')}}">
                                    </div>
                                </div>
                                <div class="new-address-content-input-groups">
                                    <div class="news-address-content-inputs">
                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                            Meta Title
                                        </label>
                                        <input type="text" class="input-class" name="meta_title"
                                               value="{{old('meta_title')}}">
                                    </div>
                                </div>
                                <div class="new-address-content-input-groups">
                                    <div class="news-address-content-inputs">
                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                            Meta Description
                                        </label>
                                        <textarea name="meta_desc" cols="30"
                                                  rows="10">{!! old('meta_desc') !!}</textarea>
                                    </div>
                                </div>
                                <div class="new-address-content-input-groups">
                                    <div class="news-address-content-inputs">
                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                            Banner
                                        </label>
                                        <input type="file" class="input-class" name="banner">
                                    </div>
                                    <div class="news-address-content-inputs">
                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                            Status
                                        </label>
                                        <label for="b">
                                            <div class="private f-size-14-b c-dblack-75">
                                                <div class="checkboxes">
                                                    <div class="check">
                                                        <input type="checkbox" name="visible" id="b">
                                                        <label for="b"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
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
@endsection
