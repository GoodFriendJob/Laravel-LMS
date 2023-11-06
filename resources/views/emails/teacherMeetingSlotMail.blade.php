@component('mail::message')
Hello **{{ $content['name'] }}**

Your meeting details are below.

Course **{{ $content['course'] }}** <br>
Lesson **{{ $content['lesson'] }}** <br>
Zoom Meeting ID **{{ $content['meeting_id'] }}** <br>
Password **{{ $content['password'] }}** <br>
Date **{{ $content['start_at']->format('d-m-Y h:i A') }} ({{ config('zoom.timezone') }})** <br>


@component('mail::button', ['url' => $content['start_url']])
    Start URL
@endcomponent

[{{ $content['start_url'] }}]({{ $content['start_url'] }}).


Thanks,<br>
{{ config('app.name') }}
@endcomponent
