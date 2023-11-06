@extends('backend.layouts.app')

@section('title', __('labels.backend.live_lessons.create').' | '.app_name())

@section('content')

    {!! Form::open(['method' => 'POST', 'route' => ['admin.live-lessons.store'], 'files' => true,]) !!}
    {!! Form::hidden('model_id',0,['id'=>'live_lesson_id']) !!}
    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('labels.backend.live_lessons.create')</h3>
            <div class="float-right">
                <a href="{{ route('admin.live-lessons.index') }}"
                   class="btn btn-success">@lang('labels.backend.live_lessons.view')</a>
            </div>
        </div>
        <div class="card-body">
            @include('backend.live-lessons.form',['liveLesson' => optional()])
            <div class="row">
                <div class="col-12  text-center form-group">
                    {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn  btn-danger']) !!}
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

@stop
