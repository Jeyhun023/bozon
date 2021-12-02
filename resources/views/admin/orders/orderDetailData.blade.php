@if($type == 1)
    <p class="pop-p"><label class="mr-2">Ad: </label> <span>{{$order->address['fullname'] ?? ''}}</span></p>
    <p class="pop-p"><label class="mr-2">Telefon: </label> <span>{{$order->address['phone'] ?? ''}}</span></p>
    <p class="pop-p"><label class="mr-2">Şəhər: </label> <span>{{$city->name ?? ''}}</span></p>
    <p class="pop-p"><label class="mr-2">Ünvan: </label> <span>{{$order->address['address'] ?? ''}}</span></p>
@else
    <p class="pop-p"><label class="mr-2">Rəng: </label> <span>{{$order->attributes['color'] ?? ''}}</span></p>
    <p class="pop-p"><label class="mr-2">Ölçü: </label> <span>{{$order->attributes['size'] ?? ''}}</span></p>
@endif
