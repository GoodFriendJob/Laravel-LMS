@extends('backend.layouts.app')
@section('title', __('labels.backend.live_lessons.edit').' | '.app_name())

@section('content')
    {!! Form::model($liveLesson, ['method' => 'PUT', 'route' => ['admin.live-lessons.update', ['live_lesson' => $liveLesson]], 'files' => true,]) !!}
    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('labels.backend.live_lessons.edit')</h3>
            <div class="float-right">
                <a href="{{ route('admin.live-lessons.index') }}"
                   class="btn btn-success">@lang('labels.backend.live_lessons.view')</a>
            </div>
        </div>
        <div class="card-body">
            @include('backend.live-lessons.form')
            <div class="row">
                <div class="col-12  text-center form-group">
                    {!! Form::submit(trans('strings.backend.general.app_update'), ['class' => 'btn  btn-danger']) !!}
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

@stop
