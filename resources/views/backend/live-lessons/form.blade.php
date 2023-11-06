<div class="row">
    <div class="col-12 col-lg-6 form-group">
        {!! Form::label('course_id', trans('labels.backend.live_lessons.fields.course'), ['class' => 'control-label']) !!}
        {!! Form::select('course_id', $courses,  (request('course_id')) ? request('course_id') : old('course_id'), ['class' => 'form-control select2']) !!}
    </div>
    <div class="col-12 col-lg-6 form-group">
        {!! Form::label('title', trans('labels.backend.live_lessons.fields.title').'*', ['class' => 'control-label']) !!}
        {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.live_lessons.fields.title')]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label('short_text', trans('labels.backend.live_lessons.fields.short_text'), ['class' => 'control-label']) !!}
        {!! Form::textarea('short_text', old('short_text'), ['class' => 'form-control ', 'placeholder' => trans('labels.backend.live_lessons.short_description_placeholder')]) !!}

    </div>
</div>
