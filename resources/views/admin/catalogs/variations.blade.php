<div class="news-address-content-inputs mb1">
    <label for="" class="label-class f-size-14-b c-dblack-op-75 mb-12">
        Price
    </label>
    <input type="text" class="input-class title_input" name="price" placeholder="Price">
    <input type="hidden" class="input-class title_input" name="productId" value="{{$product->id}}">
    <span class="error-title title_error"></span>
</div>
<div class="new-address-content-input-groups">
    <div class="price-table" id="sku_combination">
        <div class="price-table-row price-table-header">
            <div class="price-table-row-child price-table-row-first">Variant</div>
            <div class="price-table-row-child price-table-row-first">Variant Price</div>
            <div class="price-table-row-child price-table-row-first">SkU</div>
            <div class="price-table-row-child price-table-row-first">Quantity</div>
        </div>
        @php
            $k = 0;
            $y = 0;
            $clr = 0;
            $ky = -1;
        @endphp
        @foreach($product->variations as $variation)
            <div class="price-table-row-child">
                <div class="price-table-row-child price-table-row-first">
                    @php($v = explode('xx',$variation->sku))
                    {{ $variation->color->name }}-{{ $v[1] ?? 0 }}-{{ $v[2] ?? 0 }}
                </div>
                <div class="price-table-row-child">
{{--                    <input type="number" name="prices[1][0]ice_df" value="" min="0"--}}
{{--                                                          step="0.01" class="input-class">--}}
                    @if ($product->attributes->count() == 1)
                        <input type="number" name="prices[{{ $variation->color_id }}][{{ $variation->attribute_id }}][{{ $k }}]"
                               value="1" min="0" step="0.01" class="form-control">
                    @else
                        <input type="number" name="prices[{{ $variation->color_id }}][{{ $variation->attribute_id }}][{{ $k }}][{{ $y }}]"
                               value="1" min="0" step="0.01" class="form-control">
                    @endif
                </div>
                <div class="price-table-row-child">
                    <input type="text" readonly="" name="skus[1][0]" value="{{$variation->sku}}"
                                                          class="input-class" required="">
                </div>
                <div class="price-table-row-child">
{{--                    <input type="number" name="qtys[1][0]" value="1" min="0" step="1"--}}
{{--                                                          class="input-class" required="">--}}
                    @if ($product->attributes->count() == 1)
                        <input type="number" name="qtys[{{ $variation->color_id }}][{{ $variation->attribute_id }}][{{ $k++ }}]" value="1" min="0" step="1" class="form-control" required="">
                    @else
                        <input type="number" name="qtys[{{ $variation->color_id }}][{{ $variation->attribute_id }}][{{ $k++ }}][{{ $y++ }}]" value="1" min="0" step="1" class="form-control" required="">
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
