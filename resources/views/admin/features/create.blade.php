@extends('layouts.app',['title'=>"Feature add"])

@section('breadcrump')
    <div class="top-section b-black">
        <div class="container">
            <div class="top-section-inner">
                <div>
                    <div class="page-links">
                        <a class="c-white-op-75 f-size-14">Ana səhifə > </a>
                        <a href="{{route('features.index', ['category_id' => $id])}}" class="c-white-op-75 f-size-14">&emsp14;Features</a>
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
            <form action="{{route('features.store', ['category_id' => $id])}}" method="post" enctype="multipart/form-data" id="feature-create-form">
                @csrf
                <input type="hidden" value="{{$id}}" id="category_id">
                <div class="row">
                    <div class="xl-2">
                    </div>
                    <div class="xl-9">
                        <div class="new-address-content bradius-8 b-white">
                            <div class="new-address-content-header bor-bottom-black-1">
                                <span class="f-size-16">
                                    Feature Elave et <a style="color:blue;cursor:pointer" onclick="loadFeature()"><h4>+ Yeni label əlavə et</h4></a>
                                </span>
                            </div>
                            <div class="new-address-content-body">
                                <div class="new-address-content-input-groups">
                                    <div class="news-address-content-inputs">
                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                            Ad 
                                        </label>
                                        <input type="text" class="input-class" name="1[name]">
                                    </div>
                                    <div class="news-address-content-inputs">
                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                            Sıra
                                        </label>
                                        <input type="number" class="input-class" name="1[sort]">
                                    </div>
                                </div>
                                <div class="new-address-content-input-groups">
                                    <div class="news-address-content-inputs">
                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                            Value
                                        </label>
                                        <input type="text" class="input-class" name="1[values][1]">
                                    </div>
                                    <div class="news-address-content-inputs" style="margin-top:20px;"></div>
                                </div>
                                <div id="newvalue_1"></div>
                                <a style="color:blue;cursor:pointer" onclick="loadFeatureValue(1)"><h3>+ Yeni dəyər əlavə et</h3></a></br>
                                
                                <div id="newfeature_1"></div>
                                <button type="submit" id="sendButton" class="new-address-button">
                                    Yadda saxla
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="popup popup-6">
        <div class="layer-popup"></div>
        <div class="popup-container">
            <div class="popup-content popup-success">
                <div class="popup-header bor-bottom-black-1">
                    <svg width="48" height="48" viewBox="0 0 58 57" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.5" d="M10.2264 47.4145L47.8501 9.79194" stroke="#E30A17" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                        <path opacity="0.5" d="M10.2281 9.7928L47.8506 47.4165" stroke="#E30A17" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h6>
                        Xəta baş verdi
                    </h6>
                </div>
                <p class="pop-p" id="errors"></p>
                <div class="pop-buttons">
                    <button class="popup-close pop-button pop-default-button">
                        Bağla
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
