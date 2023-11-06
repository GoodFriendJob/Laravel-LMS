@component('mail::message')
# Hello Admin

In our system new user registered, User details are below

Name **{{ $user->name }}** <br>
Email **{{ $user->email }}**


Thanks,<br>
{{ config('app.name') }}
@endcomponent
