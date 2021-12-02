@foreach($items as $item)
    <option value="{{$item->id}}">{!! $prefix.$item->name !!}</option>
    @if(count($item->children2))
        @include('admin.category.child_option',['items' => $item->children2,'prefix'=>'&nbsp;&nbsp;'.$prefix])
    @endif
@endforeach
