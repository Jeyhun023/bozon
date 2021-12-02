@forelse($features as $feature)
    <div class="new-address-content-input-groups">
        <div class="news-address-content-inputs">
            <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                Başlıq
            </label>
            <input type="text" class="input-class"  disabled value="{{$feature->name ?? ''}}">
        </div>
        <div class="news-address-content-inputs">
            <label for="" class="f-size-14-b c-dblack-op-75 mb-12">
                Xüsusiyyət
            </label>
            <div class="custom-select">
                <div class="new-select-arrow"
                     style="background-image: url({{asset('img/chevron.svg')}});">
                </div>
                <select class="js-example-basic-single custom-select-header" name="features[{{$feature->name}}]">
                    <option value="">Seçin</option>
                    @foreach($feature->values as $value)
                        <option value="{{$value->name}}">{{$value->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
@empty
    <span class="f-size-16">
        Xüsusiyyət tapılmadı
    </span>
@endforelse
