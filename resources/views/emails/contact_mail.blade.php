@component('mail::message')
    <h4>Hello Admin, Following contact has messaged you from Contact Page of <a style="font-weight:bold;" href="{{env('APP_URL')}}">{{env('APP_NAME')}}</a></h4>
    Name: {{ $contactMessage->name }}
    Email: {{ $contactMessage->emails }}
    Number: {{ $contactMessage->number }}
    Message: {{ $contactMessage->message }}

    Thanks,
    {{ config('app.name') }}
@endcomponent
