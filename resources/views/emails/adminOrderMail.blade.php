@component('mail::message')
# Hello, {{ $admin->name }}

Notified new order on system are below:<br>

## Buyer Details <br>
Name: {{ auth()->user()->name }} <br>
Email: {{ auth()->user()->email }} <br>

### Order Details <br>
Order Reference No. {{$content['reference_no']}} <br>
@foreach($content['items'] as $item)
    **{{$item['number']}}. {{$item['name']}} {{$appCurrency['symbol'].$item['price']}}**<br>
@endforeach

### Total Amount : {{$appCurrency['symbol']}} {{$content['total']}}


Thanks,<br>
{{ config('app.name') }}
@endcomponent
