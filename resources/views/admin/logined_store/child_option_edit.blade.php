@foreach($items as $item)
    <option value="{{$item->id}}" @if($store->category)  @if($item->id == $store->category->id) selected @endif @endif>{!! $prefix.$item->name !!}</option>
    @if(count($item->children2))
        @include('admin.logined_store.child_option_edit',['items' => $item->children2,'prefix'=>'&nbsp;&nbsp;'.$prefix])
    @endif
@endforeach
