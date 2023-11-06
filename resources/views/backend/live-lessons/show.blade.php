@extends('backend.layouts.app')
@section('title', __('labels.backend.live_lessons.title').' | '.app_name())

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('labels.backend.live_lessons.title')</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('labels.backend.live_lessons.fields.course')</th>
                            <td>{{ $liveLesson->course->title }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.live_lessons.fields.title')</th>
                            <td>{{ $liveLesson->title }}</td>
                        </tr>

                        <tr>
                            <th>@lang('labels.backend.live_lessons.fields.short_text')</th>
                            <td>{!! $liveLesson->short_text !!}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->



            <a href="{{ route('admin.live-lessons.index') }}"
               class="btn btn-default border">@lang('strings.backend.general.app_back_to_list')</a>
        </div>
    </div>
@stop
