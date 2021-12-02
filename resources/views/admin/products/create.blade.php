@extends('layouts.app',['title'=>"Məhsullar"])

{{-- @section('body_class', 'add-product-page b-white-1') --}}

@section('breadcrump')
    <div class="top-section b-black">
        <div class="container">
            <div class="top-section-inner">
                <div>
                    <div class="page-links">
                        <a href="{{route('con.index')}}" class="c-white-op-75 f-size-14">Ana səhifə > </a>
                        <a href="{{route('products.index')}}" class="c-white-op-75 f-size-14">&emsp14;Məhsullar</a>
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

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/3.23.0/tagify.min.css" integrity="sha512-SxgrVgd3c/mmDd/98A5HXv/g1RSyvhTS/D7/a3N3kNSRqf1YEM83qyHafYZcfzjoM99ZDGEgDcDBkSpBhKKyJQ==" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="add-product-page b-white-1">
        <div class="container">
            <div class="row">
                <div class="xl-3">
                    <div class="new-address-fixed">
                        <div class="new-address bradius-8 b-white">
                            <div class="new-address-header bor-bottom-black-1">
                                <h4 class="f-size-20">
                                    Yenisini əlavə et
                                </h4>
                                <button>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.59998 1.60001L14.4 14.4M1.59998 14.4L14.4 1.60001" stroke="#0B0B18"
                                              stroke-width="2" />
                                    </svg>
                                </button>
                            </div>
                            <ul class="new-address-body" id="left-menu-slide">
                                <li>
                                    <a href="#1" class="f-size-14-b c-dblack-75 active">
                                        Haqqında
                                    </a>
                                </li>
                                <li>
                                    <a href="#2" class="f-size-14-b c-dblack-75">
                                        Xüsusiyyətlər
                                    </a>
                                </li>
                                <li>
                                    <a href="#3" class="f-size-14-b c-dblack-75">
                                        Qalereya
                                    </a>
                                </li>
                                <li>
                                    <a href="#4" class="f-size-14-b c-dblack-75">
                                        Variasiyalar
                                    </a>
                                </li>
{{--                                <li>--}}
{{--                                    <a href="#4" class="f-size-14-b c-dblack-75">--}}
{{--                                        Əlaqəli məhsullar--}}
{{--                                    </a>--}}
{{--                                </li>--}}
                                <li>
                                    <a href="#5" class="f-size-14-b c-dblack-75">
                                        SEO
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="xl-9">
                    <form action="{{route('admin.products.store')}}" method="post" enctype="multipart/form-data" id="productStoreForm">
                        @csrf
                        <div class="new-address-content" id="1">
                            <div class="bradius-8 b-white">
                                <div class="new-address-content-header bor-bottom-black-1">
                                    <span class="f-size-16">
                                        Haqqında
                                    </span>
                                </div>
                                <div class="new-address-content-body">
                                    <div class="new-address-content-input-groups">
                                        <div class="news-address-content-inputs">
                                            <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                                Başlıq
                                            </label>
                                            <input type="text" class="input-class" name="title" placeholder="Başlıq..." value="{{ old('title') }}">
                                        </div>
                                        <div class="news-address-content-inputs">
                                            <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                                Kateqoriya
                                            </label>
                                            <div class="custom-select">
                                                <div class="new-select-arrow"
                                                     style="background-image: url({{asset('img/chevron.svg')}});">
                                                </div>
                                                <select class="js-example-basic-single custom-select-header categorySelect" name="category">
                                                    @foreach ($categories as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                        @if ($item->children)
                                                            @foreach ($item->children as $ct)
                                                                <option value="{{ $ct->id }}">&emsp; - {{ $ct->name }}
                                                                </option>
                                                                @if($ct->children)
                                                                    @foreach ($ct->children as $ctc)
                                                                        <option value="{{ $ctc->id }}">&emsp; &emsp; - {{ $ctc->name }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="new-address-content-input-groups">
                                        <div class="news-address-content-inputs">
                                            <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                                Brend
                                            </label>
                                            <div class="custom-select">
                                                <div class="new-select-arrow"
                                                     style="background-image: url({{asset('img/chevron.svg')}});">
                                                </div>
                                                <select class="js-example-basic-single custom-select-header" name="brand">
                                                    @foreach ($brands as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="news-address-content-inputs">
                                            <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                                Rəng
                                            </label>
                                            <div class="custom-select">
                                                <select class="js-example-basic-single" name="colors[]"
                                                        multiple="multiple">
                                                    @foreach ($colors as $item)
                                                        <option value="{{$item->id}}"
                                                                data-content="<span style='display: inline-block;width: min-content;'><p style='display:flex;align-items: center;'><i style='border:1px solid black;width:10px;margin-right: 7px;height:10px;padding:5px;background-color:{{ $item->code }}'></i>{{ $item->name }}</p></span>"
                                                                data-name="{{ $item->name }}">{{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="new-address-content-input-groups">
                                        <div class="news-address-content-inputs">
                                            <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                                Haqqında
                                            </label>
                                            <!-- <textarea class="textarea-class input-class" placeholder="Məhsul haqqında..."></textarea> -->
                                            <textarea id="mytextarea" class="mytextarea" name="description"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="new-address-content" id="2">
                            <div class="bradius-8 b-white">
                                <div class="new-address-content-header bor-bottom-black-1">
                                    <span class="f-size-16">
                                        Xüsusiyyətlər
                                    </span>
                                </div>
                                <div class="new-address-content-body featuresBody">
                                    <span class="f-size-16">
                                        Kateqoriya seçilməyib
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="new-address-content" id="3">
                            <div class="bradius-8 b-white">
                                <div class="new-address-content-header bor-bottom-black-1">
                                    <span class="f-size-16">
                                        Qalereya
                                    </span>
                                </div>
                                <div class="new-address-content-body">
                                    <div class="new-address-file">
                                        <label for="" class="f-size-14-b c-dblack-op-75">
                                            Əsas şəkil
                                        </label>
                                        <div class="mobile-select">
                                            <input type="file" class="input-class" required  name="thumbnail" accept=".png, .jpg, .jpeg">
                                        </div>
                                    </div>
                                    <div class="new-address-file">
                                        <label for="" class="f-size-14-b c-dblack-op-75">
                                            Digər şəkillər
                                        </label>
                                        <input type="hidden" name="images" value="" id="images">
                                        <div class=" dropzone dz-default dz-message" id="kt_dropzone_1">
                                            <img src="{{ asset('img/folder.png') }}" alt="">
                                            <h5>
                                                <span> Fayllardan seç</span> və ya sürüşdürüb bura at
                                            </h5>
                                            <p>Maksimum 5 MB, JPEG, PNG, PDF</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="new-address-content" id="4">
                            <div class="bradius-8 b-white">
                                <div class="new-address-content-header bor-bottom-black-1">
                                    <span class="f-size-16">
                                        Variasiyalar
                                    </span>
                                </div>
                                <div class="new-address-content-body">
                                    <div class="new-address-content-input-groups">
                                        <div class="news-address-content-inputs">
                                            <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                                Attributlar
                                            </label>
                                            <div class="custom-select">
                                                <select class="js-example-basic-single" name="attributes[]" id="attributes"
                                                        multiple="multiple">
                                                    @foreach ($attributes as $item)
                                                        <option data-name="{{ $item->name }}" value="{{ $item->id }}">
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="news-address-content-inputs" id="attrs">
                                            <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                                Attribut seçimləri
                                            </label>
                                        </div>
                                    </div>
                                    <div class="new-address-content-input-groups">
                                        <div class="news-address-content-inputs">
                                            <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                                Qiymət
                                            </label>
                                            <input type="text" class="input-class" placeholder="100" name="price" id="price"
                                                   value="{{ old('price') }}" />
                                        </div>
                                        <div class="news-address-content-inputs">
                                            <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                                Stok
                                            </label>
                                            <input type="text" class="input-class" name="qty" value="1">
                                        </div>
                                    </div>
                                    <div class="new-address-content-input-groups">
                                        <div class="news-address-content-inputs">
                                            <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                                Endirim
                                            </label>
                                            <input type="text" class="input-class">

                                        </div>
                                        <div class="news-address-content-inputs">
                                            <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                                Endirim tipi
                                            </label>
                                            <div class="custom-select">
                                                <select class="js-example-basic-single" name="discount_type">
                                                    <option value="1">Amount</option>
                                                    <option value="2">Percent</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="new-address-content-input-groups">
                                        <div class="price-table" id="sku_combination">
                                            <div class="price-table-row price-table-header">
                                                <div class="price-table-row-child price-table-row-first">
                                                    Variant
                                                </div>
                                                <div class="price-table-row-child">
                                                    Variant Price
                                                </div>
                                                <div class="price-table-row-child">
                                                    SkU
                                                </div>
                                                <div class="price-table-row-child">
                                                    Quantity
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
{{--                        <div class="new-address-content" id="4">--}}
{{--                            <div class="bradius-8 b-white">--}}
{{--                                <div class="new-address-content-header bor-bottom-black-1">--}}
{{--                                    <span class="f-size-16">--}}
{{--                                      Əlaqəli məhsullar--}}
{{--                                    </span>--}}
{{--                                </div>--}}
{{--                                <div class="new-address-content-body">--}}
{{--                                    <div class="news-address-content-inputs" id="attrs">--}}
{{--                                        <label for="" class="f-size-14-b c-dblack-op-75 mb-12">--}}
{{--                                            Məhsul id-lərin əlavə et--}}
{{--                                        </label>--}}
{{--                                        <div class="custom-select mb-12">--}}
{{--                                            <input id="kt_tagify" class="tagify" name="products"  autofocus="">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="new-address-content" id="5">
                            <div class="bradius-8 b-white">
                                <div class="new-address-content-header bor-bottom-black-1">
                                    <span class="f-size-16">
                                        SEO
                                    </span>
                                </div>
                                <div class="new-address-content-body">
                                    <div class="new-address-content-input-groups">
                                        <div class="news-address-content-inputs">
                                            <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                                Meta başlıq
                                            </label>
                                            <input type="text" name="meta[title]" class="input-class">
                                        </div>
                                        <div class="news-address-content-inputs">
                                            <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                                Alt başlıq
                                            </label>
                                            <input type="text" name="meta[subtitle]" class="input-class">
                                        </div>
                                    </div>
                                    <div class="new-address-content-input-groups">
                                        <div class="news-address-content-inputs">
                                            <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                                                Təsvir
                                            </label>
                                            <textarea class="textarea-class input-class" name="meta[description]"
                                                      placeholder="Məhsul haqqında..."></textarea>
                                        </div>
                                    </div>
                                    <button type="submit" class="new-address-button">
                                        Yadda saxla
                                    </button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        let fileUrl = "{{ route('admin.file.upload', 'product') }}";
        let productsUrl = "{{ route('admin.products.index') }}";
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/3.23.0/tagify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/actions/dropzonejs.js') }}"></script>
    <script src="{{ asset('js/tagify.js') }}"></script>
    <script>
        $('.js-example-basic-single').select2();
        var inputElement =document.querySelector('.tagify')
        var tagify = new Tagify(inputElement)
        $('#attributes').on('change', function() {
            let selects = [];
            $.each($("#attributes option:selected"), function(j, attribute) {
                flag = false;
                $('input[name="attribute_choice[]"]').each(function(i, choice_no) {
                    if ($(attribute).val() == $(choice_no).val()) {
                        flag = true;
                    }
                });
                if (!flag) {
                    add_more_customer_choice_option($(attribute).val(), $(attribute).text());
                }
                selects.push($(attribute).val());
            });
            $('input[name="attribute_choice[]"]').each(function(i, choice_no) {
                if (selects.includes($(choice_no).val())) {
                    flag = true;
                } else {
                    $(choice_no).parent().remove();
                }
            });
            update_sku();
        });

        function update_sku() {
            $("#sku_combination").html('');
            let text = "",
                price = $("#price").val(),
                firstVariations, secondVariations, kke, kkel;
            let attributes = $("#attributes option:selected");
            $.each(attributes, function(i, attribute) {
                if (attributes.length == 1) {
                    let variations = $('input[name="variations[' + $(attribute).val() + ']"]');
                    $.each(variations, function(k, variation) {
                        if ($(variation).val() != '') {
                            let items = JSON.parse($(variation).val());
                            if (items.length) {
                                kke = 0;
                                items.forEach(element => {
                                    text = text.concat('\n'
                                        +'<div class="price-table-row-child">'
                                        +    '<div class="price-table-row-child">'+$(attribute).data('name') + '' + '-' + element.value+'</div>'
                                        +    '<div class="price-table-row-child"><input type="number" name="prices['+ $(attribute).val() +']['+ kke +']" value="'+ price +'" min="0" step="0.01" class="input-class"></div>'
                                        +    '<div class="price-table-row-child"><input type="text" readonly value="'+$(attribute).val() + 'xxxx' + kke +'" class="input-class" required=""></div>'
                                        +    '<div class="price-table-row-child"><input type="number" name="qtys['+ $(attribute).val() +']['+ kke +']" value="1" min="0" step="1" class="input-class" required=""></div>'
                                        +'</div>');
                                    kke++;
                                });
                            }
                        }
                    });
                } else {
                    $.each(attributes, function(kk, aa) {
                        if (kk == 0) {
                            firstVariations = $('input[name="variations[' + $(aa).val() + ']"]');
                        } else {
                            secondVariations = $('input[name="variations[' + $(aa).val() + ']"]');
                        }
                    });
                    $.each(firstVariations, function(k, firstVariation) {
                        if ($(firstVariation).val() != '') {
                            let firstItems = JSON.parse($(firstVariation).val());
                            // let firstItems = $(firstVariation).val().split(',');
                            if (firstItems.length) {
                                kkel = 0;
                                firstItems.forEach(firstElement => {
                                    $.each(secondVariations, function(k, secondVariation) {
                                        if ($(secondVariation).val() != '') {
                                            let secondItems = JSON.parse($(secondVariation).val());
                                            // let secondItems = $(secondVariation).val().split(',');
                                            if (secondItems.length) {
                                                kke = 0;
                                                secondItems.forEach(secondElement => {
                                                    text = text.concat('\n'
                                                        +'<div class="price-table-row-child">'
                                                        +    '<div class="price-table-row-child price-table-row-first">'+$(attribute).data('name') + '-'+ firstElement.value + '-' + secondElement.value+'</div>'
                                                        +    '<div class="price-table-row-child"><input type="number" name="prices['+ $(attribute).val() +']['+ kkel +']['+ kke +']" value="'+ price +'" min="0" step="0.01" class="input-class"></div>'
                                                        +    '<div class="price-table-row-child"><input type="text" readonly name="skus['+ $(attribute).val() +']['+ kkel +']['+ kke +']" value="xx' + kkel + 'xx' + kke +'" class="input-class" required=""></div>'
                                                        +    '<div class="price-table-row-child"><input type="number" name="qtys['+ $(attribute).val() +']['+ kkel +']['+ kke +']" value="1" min="0" step="1" class="input-class" required=""></div>'
                                                        +'</div>');
                                                    kke++;
                                                });
                                            }
                                        } else {
                                            text = text.concat('\n'
                                                +'<div class="price-table-row-child">'
                                                +    '<div class="price-table-row-child price-table-row-first">'+$(attribute).data('name')+ '-'+ firstElement.value +'</div>'
                                                +    '<div class="price-table-row-child"><input type="number" name="prices['+$(attribute).val()+']['+ kkel +']ice_df" value="'+ price +'" min="0" step="0.01" class="input-class"></div>'
                                                +    '<div class="price-table-row-child"><input type="text" readonly name="skus['+$(attribute).val()+']['+ kkel +']" value="'+$(attribute).val() +'xx' + kkel + 'xx' + '" class="input-class" required=""></div>'
                                                +    '<div class="price-table-row-child"><input type="number" name="qtys['+$(attribute).val()+']['+ kkel +']" value="1" min="0" step="1" class="input-class" required=""></div>'
                                                +'</div>');
                                        }
                                    });
                                    kkel++;
                                });
                            }
                        }
                    });
                    return false;
                }
            });
            let table = '<div class="price-table-row price-table-header">' +
                '<div class="price-table-row-child price-table-row-first">Variant</div>' +
                '<div class="price-table-row-child price-table-row-first">Variant Price</div>' +
                '<div class="price-table-row-child price-table-row-first">SkU</div>' +
                '<div class="price-table-row-child price-table-row-first">Quantity</div>' +
                '</div>' + text;
            $("#sku_combination").html(table);
        }

        function add_more_customer_choice_option(i, name) {
            $('#attrs').append(
                '<div class="custom-select mb-12">' +
                '<input type="hidden" name="attribute_choice[]" value="' + i + '">' +
                '<input id="kt_tagify_' + i + '" class="tagify" name="variations[' + i +
                ']" placeholder="'+name+'" autofocus="">' +
                '</div>'
            );
            var input = document.getElementById("kt_tagify_" + i);

            let taggify = new Tagify(input);
            taggify.on('add', update_sku).on('remove', update_sku);
        }

        var serializeForm = function (form) {
            var obj = {};
            var formData = new FormData(form);
            for (var key of formData.keys()) {
                obj[key] = formData.get(key);
                console.log(formData.get(key));
            }
            return obj;
        };

        $("#productStoreForm").submit(async function(e){
            e.preventDefault();
            let form = $(this);
            let text = "";
            var formData = new FormData(e.target);
            const fileField = document.querySelector('input[type="file"]');
            formData.append('thumbnail', fileField.files[0]);
            await fetch(form.attr('action'), {
                method:'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'accept':'application/json',
                },
                body: formData,
            }).then(function(res) {
                if(res.status != 201)
                    return res.json();
                else
                    successSave();
                setTimeout(function () {
                    // window.location.reload();
                    window.location.href = productsUrl;
                }, 2000);

            }).then(function(res) {
                if(res.errors){
                    return res.errors;
                }
            }).then(function(errors) {
                if (Array.isArray(errors)) {
                    for(x in errors){
                        text += '<p class="pop-p">'+ errors[x][0] + '<p>';
                    }
                } else {
                    text = '<p class="pop-p">'+ errors + '<p>';
                }

                error(text)
            }).catch(function(e) {
                console.log('Error', e);
            });
        });


        // features

        $('.categorySelect').on('change',function (e){
            var categoryId = $(this).val();
            console.log(categoryId)
            $.get('/v2/admin/products/getFeaturesByCategory/'+categoryId,function (result){
                $('.featuresBody').html(' ').append(result)
                $('.js-example-basic-single').select2();
            });
        })

    </script>
@endpush
