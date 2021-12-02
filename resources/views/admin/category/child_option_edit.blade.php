@foreach($items as $item)
    <option value="{{$item->id}}" @if($item->id == $cat->parent_id) selected @endif>{!! $prefix.$item->name !!}</option>
    @if(count($item->children2))
        @include('admin.category.child_option_edit',['items' => $item->children2,'prefix'=>'&nbsp;&nbsp;'.$prefix])
    @endif
@endforeach
