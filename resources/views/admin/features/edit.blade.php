@extends('layouts.app',['title'=>"Features"])

@section('breadcrump')
    <div class="top-section b-black">
        <div class="container">
            <div class="top-section-inner">
                <div>
                    <div class="page-links">
                        <a class="c-white-op-75 f-size-14">Ana səhifə > </a>
                        <a href="{{route('features.index', ['category_id' => $id])}}" class="c-white-op-75 f-size-14">&emsp14;Features</a>
                        <span class="c-white-op-50 f-size-14">
                                Redakte et
                            </span>
                    </div>
                    <h6 class="f-size-24 c-white">
                        Redakte et
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
            <form action="{{route('features.update', ['feature' => $feature->id,'category_id' => $id])}}" method="post"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" value="{{$id}}" id="category_id">
                <div class="row">
                    <div class="xl-2">
                    </div>
                    <div class="xl-9">
                        <div class="new-address-content bradius-8 b-white">
                            <div class="new-address-content-header bor-bottom-black-1">
                                <span class="f-size-16">
                                    Feature redakte et 
                                </span>
                            </div>
                            <div class="new-address-content-body">
                                <div class="new-address-content-input-groups">
                                    <div class="news-address-content-inputs">
                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                            Ad 
                                        </label>
                                        <input type="text" class="input-class" name="1[name]" value="{{$feature->name}}">
                                    </div>
                                    <div class="news-address-content-inputs">
                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                            Sıra
                                        </label>
                                        <input type="number" class="input-class" name="1[sort]" value="{{$feature->sort}}">
                                    </div>
                                </div>
                                    @foreach($feature->values as $item)
                                    <div class="new-address-content-input-groups">
                                        <div class="news-address-content-inputs">
                                            <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                                Value
                                            </label>
                                            <input type="text" class="input-class" name="edit[{{$item->id}}]" value="{{$item->name}}">
                                        </div>
                                        <div class="news-address-content-inputs" style="margin-top:20px;">
                                            <button class="delete-search-result active" type="button" onclick="deletepop40('{!! route('features.value.delete',['id' => $item->id]) !!}','values')">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g><path d="M5.25714 3.32143V1.92857C5.25714 1.41574 5.66648 1 6.17143 1H9.82857C10.3335 1 10.7429 1.41574 10.7429 1.92857V3.32143M1 3.78571H15M3.37143 3.78571V13.0714C3.37143 13.5843 3.78077 14 4.28571 14H11.7143C12.2192 14 12.6286 13.5843 12.6286 13.0714V3.78571M8 6.62958V10.2277V11.4175" stroke="#05061E"></path></g>
                                                </svg>
                                                <span class="f-size-14">Sil</span>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
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
@endsection
