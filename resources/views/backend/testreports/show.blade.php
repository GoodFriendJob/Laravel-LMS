@extends('backend.layouts.app')
@section('title', __('labels.backend.lessons.title').' | '.app_name())

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('labels.backend.lessons.title')</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('labels.backend.lessons.fields.course')</th>
                            <td>{{ $lesson->course->title or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.lessons.fields.title')</th>
                            <td>{{ $lesson->title }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.lessons.fields.slug')</th>
                            <td>{{ $lesson->slug }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.lessons.fields.lesson_image')</th>
                            <td>@if($lesson->lesson_image)<a href="{{ asset('storage/uploads/' . $lesson->lesson_image) }}" target="_blank"><img
                                            src="{{ asset('storage/uploads/' . $lesson->lesson_image) }}" height="100px"/></a>@endif</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.lessons.fields.short_text')</th>
                            <td>{!! $lesson->short_text !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.lessons.fields.full_text')</th>
                            <td>{!! $lesson->full_text !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.lessons.fields.position')</th>
                            <td>{{ $lesson->position }}</td>
                        </tr>

                        <tr>
                            <th>@lang('labels.backend.lessons.fields.media_pdf')</th>
                            <td>
                                @if($lesson->mediaPDF != null )
                                <p class="form-group">
                                    <a href="{{$lesson->mediaPDF->url}}" target="_blank">{{$lesson->mediaPDF->url}}</a>
                                </p>
                                @else
                                    <p>No PDF</p>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.lessons.fields.media_audio')</th>
                            <td>
                                @if($lesson->mediaAudio != null )
                                <p class="form-group">
                                    <a href="{{$lesson->mediaAudio->url}}" target="_blank">{{$lesson->mediaAudio->url}}</a>
                                </p>
                                @else
                                    <p>No Audio</p>
                                @endif
                            </td>
                        </tr>

                        <tr>

                            <th>@lang('labels.backend.lessons.fields.downloadable_files')</th>
                            <td>
                                @if(count($lesson->downloadableMedia) > 0 )
                                    @foreach($lesson->downloadableMedia as $media)
                                        <p class="form-group">
                                            <a href="{{ asset('storage/uploads/'.$media->name) }}"
                                               target="_blank">{{ $media->name }}
                                                ({{ $media->size }} KB)</a>
                                        </p>
                                    @endforeach
                                @else
                                    <p>No Files</p>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.lessons.fields.media_video')</th>
                            <td>
                                @if($lesson->mediaVideo !=  null )
                                        <p class="form-group">
                                           <a href="{{$lesson->mediaVideo->url}}" target="_blank">{{$lesson->mediaVideo->url}}</a>
                                        </p>
                                @else
                                    <p>No Videos</p>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.lessons.fields.published')</th>
                            <td>{{ Form::checkbox("published", 1, $lesson->published == 1 ? true : false, ["disabled"]) }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->



            <a href="{{ route('admin.lessons.index') }}"
               class="btn btn-default border">@lang('strings.backend.general.app_back_to_list')</a>
        </div>
    </div>
@stop