@inject('request', 'Illuminate\Http\Request')
@extends('backend.layouts.app')
@section('title', __('labels.backend.live_lesson_slots.title').' | '.app_name())

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">@lang('labels.backend.live_lesson_slots.title')</h3>
            @can('live_lesson_slot_create')
                <div class="float-right">
                    <a href="{{ route('admin.live-lesson-slots.create') }}@if(request('lesson_id')){{'?lesson_id='.request('lesson_id')}}@endif"
                       class="btn btn-success">@lang('strings.backend.general.app_add_new')</a>

                </div>
            @endcan
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('lesson_id', trans('labels.backend.live_lesson_slots.fields.lesson'), ['class' => 'control-label']) !!}
                    {!! Form::select('lesson_id', $liveLessons,  (request('lesson_id')) ? request('lesson_id') : old('lesson_id'), ['class' => 'form-control js-example-placeholder-single select2 ', 'id' => 'lesson_id']) !!}
                </div>
            </div>

            @if(request('lesson_id') != "" || request('show_deleted') != "")
                <div class="table-responsive">

                    <table id="myTable"
                           class="table table-bordered table-striped @can('live_lesson_slot_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                        <thead>
                        <tr>
                            <th>@lang('labels.backend.live_lesson_slots.slot')</th>

                            <th>@lang('labels.backend.live_lessons.fields.course')</th>
                            <th>@lang('labels.backend.live_lesson_slots.fields.meeting_id')</th>
                            <th>@lang('labels.backend.live_lesson_slots.fields.password')</th>
                            <th>@lang('labels.backend.live_lesson_slots.fields.duration')</th>
                            <th>@lang('labels.backend.live_lesson_slots.fields.date')</th>
                            <th>@lang('labels.backend.live_lesson_slots.start_url')</th>
                            @if( request('show_deleted') == 1 )
                                <th>@lang('strings.backend.general.actions') &nbsp;</th>
                            @else
                                <th>@lang('strings.backend.general.actions') &nbsp;</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
            @endif

        </div>
    </div>

@stop

@push('after-scripts')
    <script>

        $(document).ready(function () {
            var route = '{{route('admin.live-lesson-slots.get_data')}}';


            @php
            $show_deleted = (request('show_deleted') == 1) ? 1 : 0;
            $lesson_id = (request('lesson_id') != "") ? request('lesson_id') : 0;
            $route = route('admin.live-lesson-slots.get_data',['show_deleted' => $show_deleted,'lesson_id' => $lesson_id]);
            @endphp

            route = '{{$route}}';
            route = route.replace(/&amp;/g, '&');

            @if(request('lesson_id') != "" || request('show_deleted') != "")

            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 10,
                retrieve: true,
                dom: 'lfBrtip<"actions">',
                buttons: [
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4, 5]
                        }
                    },
                    'colvis'
                ],
                ajax: route,
                columns: [
                    {data: "DT_RowIndex", name: 'DT_RowIndex', searchable: false, orderable:false},
                    {data: "course", name: 'course', searchable: false, orderable: false},
                    {data: "meeting_id", name: 'meeting_id', searchable: false, orderable:false},
                    {data: "password", name: 'password', searchable: false, orderable:false},
                    {data: "duration", name: 'duration', searchable: false, orderable:false},
                    {data: "start_at", name: 'start_at', searchable: false, orderable:false},
                    {data: "start_url", name: 'start_url', searchable: false, orderable:false},
                    {data: "actions", name: "actions", searchable: false, orderable:false}
                ],
                @if(request('show_deleted') != 1)
                columnDefs: [
                    {"width": "5%", "targets": 0},
                    {"className": "text-center", "targets": [0]}
                ],
                @endif

                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-entry-id', data.id);
                },
                language:{
                    url : "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/{{$locale_full_name}}.json",
                    buttons :{
                        colvis : '{{trans("datatable.colvis")}}',
                        pdf : '{{trans("datatable.pdf")}}',
                        csv : '{{trans("datatable.csv")}}',
                    }
                }
            });

            @endif

            $(".js-example-placeholder-single").select2({
                placeholder: "{{trans('labels.backend.live_lesson_slots.select_lesson')}}",
            });
            $(document).on('change', '#lesson_id', function (e) {
                var lesson_id = $(this).val();
                window.location.href = "{{route('admin.live-lesson-slots.index')}}" + "?lesson_id=" + lesson_id
            });
        });

    </script>
@endpush
