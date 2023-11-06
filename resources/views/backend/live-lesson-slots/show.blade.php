@extends('backend.layouts.app')
@section('title', __('labels.backend.live_lesson_slots.title').' | '.app_name())

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('labels.backend.live_lesson_slots.title')</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('labels.backend.live_lessons.fields.course')</th>
                            <td>{{ $liveLessonSlot->lesson->course->title }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.live_lesson_slots.fields.lesson')</th>
                            <td>{{ $liveLessonSlot->lesson->title }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.live_lesson_slots.fields.meeting_id')</th>
                            <td>{{ $liveLessonSlot->meeting_id }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.live_lesson_slots.fields.topic')</th>
                            <td>{{ $liveLessonSlot->topic }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.live_lesson_slots.fields.short_text')</th>
                            <td>{!! $liveLessonSlot->description !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.live_lesson_slots.fields.duration')</th>
                            <td>{!! $liveLessonSlot->duration !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.live_lesson_slots.fields.date')</th>
                            <td>{!! $liveLessonSlot->start_at->format('d-m-Y h:i:s A') !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.live_lesson_slots.start_url')</th>
                            <td>
                                <a href="{{ $liveLessonSlot->start_url }}" target="_blank" class="btn btn-info">
                                    @lang('labels.backend.live_lesson_slots.start_url')
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->

            @if($liveLessonSlot->lessonSlotBookings->count())
            <h4> @lang('labels.backend.live_lesson_slots.slot_booked_student_list')</h4>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <tr>
                            <th>@lang('labels.backend.live_lesson_slots.student_name')</th>
                            <th>@lang('labels.backend.live_lesson_slots.student_email')</th>
                        </tr>
                        @forelse($liveLessonSlot->lessonSlotBookings as $booking)
                        <tr>
                            <td>{{ $booking->user->name }}</td>
                            <td>{{ $booking->user->email }}</td>
                        </tr>
                        @empty
                        @endforelse
                    </table>
                </div>
            </div>
            @endif

            <a href="{{ route('admin.live-lesson-slots.index') }}"
               class="btn btn-default border">@lang('strings.backend.general.app_back_to_list')</a>
        </div>
    </div>
@stop
