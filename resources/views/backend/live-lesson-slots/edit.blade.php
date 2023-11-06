@extends('backend.layouts.app')
@section('title', __('labels.backend.live_lesson_slots.edit').' | '.app_name())

@section('content')
    {!! Form::model($liveLessonSlot, ['method' => 'PUT', 'route' => ['admin.live-lesson-slots.update', ['live_lesson_slot' => $liveLessonSlot]], 'files' => true,]) !!}
    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('labels.backend.live_lesson_slots.edit')</h3>
            <div class="float-right">
                <a href="{{ route('admin.live-lesson-slots.index') }}"
                   class="btn btn-success">@lang('labels.backend.live_lesson_slots.view')</a>
            </div>
        </div>
        <div class="card-body">
            @include('backend.live-lesson-slots.form')
            <div class="row">
                <div class="col-12  text-center form-group">
                    {!! Form::submit(trans('strings.backend.general.app_update'), ['class' => 'btn  btn-danger']) !!}
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

@stop
