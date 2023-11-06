<div class="row">
    <div class="col-12 col-lg-6 form-group">
        {!! Form::label('lesson_id', trans('labels.backend.live_lesson_slots.fields.lesson'), ['class' => 'control-label']) !!}
        {!! Form::select('lesson_id', $lessons,  (request('lesson_id')) ? request('lesson_id') : old('lesson_id'), ['class' => 'form-control select2']) !!}
    </div>
    <div class="col-12 col-lg-6 form-group">
        {!! Form::label('topic', trans('labels.backend.live_lesson_slots.fields.topic').'*', ['class' => 'control-label']) !!}
        {!! Form::text('topic', old('topic'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.live_lesson_slots.fields.topic'), 'required' => true]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label('short_text', trans('labels.backend.live_lesson_slots.fields.short_text').'*', ['class' => 'control-label']) !!}
        {!! Form::textarea('description', old('description'), ['class' => 'form-control ', 'placeholder' => trans('labels.backend.live_lesson_slots.short_description_placeholder'), 'required' => true]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 col-lg-6 form-group">
        {!! Form::label('start_at', trans('labels.backend.live_lesson_slots.fields.date_of_slot').'*', ['class' => 'control-label']) !!}
        {!! Form::datetimeLocal('start_at', $liveLessonSlot->id?$liveLessonSlot->start_at->format('Y-m-d\TH:i'):old('start_at'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.live_lesson_slots.fields.date_of_slot'),'required' => true, 'min' => $liveLessonSlot->id ? $liveLessonSlot->start_at->format('Y-m-d\TH:i'): '']) !!}
    </div>
    <div class="col-12 col-lg-6 form-group">
        {!! Form::label('duration', trans('labels.backend.live_lesson_slots.fields.duration').'*', ['class' => 'control-label']) !!}
        {!! Form::number('duration', old('duration'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.live_lesson_slots.fields.duration'), 'required' => true, 'min' => 10]) !!}
    </div>
</div>
<div class="row">
    <div class="col-12 col-lg-6 form-group">
        {!! Form::label('password', trans('labels.backend.live_lesson_slots.fields.password').'*', ['class' => 'control-label']) !!}
        {!! Form::text('password', old('password'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.live_lesson_slots.fields.password'), 'required' => true]) !!}
    </div>
    <div class="col-12 col-lg-6 form-group">
        {!! Form::label('student_limit', trans('labels.backend.live_lesson_slots.fields.student_limit').'*', ['class' => 'control-label']) !!}
        {!! Form::number('student_limit', old('student_limit'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.live_lesson_slots.fields.student_limit'), 'required' => true,  'min' => 1, 'max' => 20]) !!}
    </div>
</div>


<div class="row">
    <div class="col-12 col-lg-6 form-group">
        {!! Form::label('change_default_setting', trans('labels.backend.live_lesson_slots.fields.change_default_setting'), ['class' => 'control-label']) !!}
        <div class="form-control border-0 p-0">
            {{ html()->label(
                   html()->checkbox('change_default_setting', false)->id('change_default_setting')
                         ->class('switch-input')->value(1)
                   . '<span class="switch-label"></span><span class="switch-handle"></span>')
               ->class('switch switch-sm switch-3d switch-primary')
           }}
        </div>
    </div>
</div>
<div class="row d-none" id="zoom_setting_div">
    <div class="col-12 col-lg-6 form-group">
        {!! Form::label('audio_option', trans('labels.backend.zoom_setting.fields.audio_option'), ['class' => 'control-label']) !!}
        {!! Form::select('audio', ['both'=> trans('labels.backend.zoom_setting.audio_options.both'), 'telephony' => trans('labels.backend.zoom_setting.audio_options.telephony'), 'voip' => trans('labels.backend.zoom_setting.audio_options.voip')],null, ['class' => 'form-control']) !!}
    </div>
    <div class="col-12 col-lg-6 form-group">
        {!! Form::label('audio_option', trans('labels.backend.zoom_setting.fields.meeting_join_approval'), ['class' => 'control-label']) !!}
        {!! Form::select('approval_type', ['0'=> trans('labels.backend.zoom_setting.meeting_approval_options.automatically'), '1' => trans('labels.backend.zoom_setting.meeting_approval_options.manually'), '2' => trans('labels.backend.zoom_setting.meeting_approval_options.no_registration_required')],null, ['class' => 'form-control']) !!}
    </div>
    <div class="col-12 col-lg-6 form-group">
        {!! Form::label('join_before_host', trans('labels.backend.zoom_setting.fields.join_before_host'), ['class' => 'control-label']) !!}
        <div class="form-control border-0 p-0">
            {{ html()->label(
                   html()->checkbox('join_before_host', false)
                         ->class('switch-input')->value(1)
                   . '<span class="switch-label"></span><span class="switch-handle"></span>')
               ->class('switch switch-sm switch-3d switch-primary')
           }}
        </div>
    </div>
    <div class="col-12 col-lg-6 form-group">
        {!! Form::label('host_video', trans('labels.backend.zoom_setting.fields.host_video'), ['class' => 'control-label']) !!}
        <div class="form-control border-0 p-0">
            {{ html()->label(
                   html()->checkbox('host_video', false)
                         ->class('switch-input')->value(1)
                   . '<span class="switch-label"></span><span class="switch-handle"></span>')
               ->class('switch switch-sm switch-3d switch-primary')
           }}
        </div>
    </div>
    <div class="col-12 col-lg-6 form-group">
        {!! Form::label('participant_video', trans('labels.backend.zoom_setting.fields.participant_video'), ['class' => 'control-label']) !!}
        <div class="form-control border-0 p-0">
            {{ html()->label(
                   html()->checkbox('participant_video', false)
                         ->class('switch-input')->value(1)
                   . '<span class="switch-label"></span><span class="switch-handle"></span>')
               ->class('switch switch-sm switch-3d switch-primary')
           }}
        </div>
    </div>
    <div class="col-12 col-lg-6 form-group">
        {!! Form::label('participant_mic_mute', trans('labels.backend.zoom_setting.fields.participant_mic_mute').'*', ['class' => 'control-label']) !!}
        <div class="form-control border-0 p-0">
            {{ html()->label(
                   html()->checkbox('participant_mic_mute', false)
                         ->class('switch-input')->value(1)
                   . '<span class="switch-label"></span><span class="switch-handle"></span>')
               ->class('switch switch-sm switch-3d switch-primary')
           }}
        </div>
    </div>
    <div class="col-12 col-lg-6 form-group">
        {!! Form::label('waiting_room', trans('labels.backend.zoom_setting.fields.waiting_room'), ['class' => 'control-label']) !!}
        <div class="form-control border-0 p-0">
            {{ html()->label(
                   html()->checkbox('waiting_room', false)
                         ->class('switch-input')->value(1)
                   . '<span class="switch-label"></span><span class="switch-handle"></span>')
               ->class('switch switch-sm switch-3d switch-primary')
           }}
        </div>
    </div>

</div>

@push('after-scripts')
    <script>
        $(document).on('click', '#change_default_setting', function (e) {
            if ($('#zoom_setting_div').hasClass('d-none')) {
                $('#change_default_setting').attr('checked', 'checked');
                $('#zoom_setting_div').removeClass('d-none');
            } else {
                $('#zoom_setting_div').addClass('d-none');
            }
        });
    </script>
@endpush

