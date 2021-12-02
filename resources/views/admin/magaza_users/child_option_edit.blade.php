@foreach($items as $item)
    <option value="{{$item->id}}" @if($magaza->category)  @if($item->id == $magaza->category->id) selected @endif @endif>{!! $prefix.$item->name !!}</option>
    @if(count($item->children2))
        @include('admin.magaza_users.child_option_edit',['items' => $item->children2,'prefix'=>'&nbsp;&nbsp;'.$prefix])
    @endif
@endforeach
