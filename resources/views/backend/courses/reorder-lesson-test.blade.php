@inject('request', 'Illuminate\Http\Request')
@extends('backend.layouts.app')
@section('title', __('labels.backend.lessons_tests.title').' | '.app_name())

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">@lang('labels.backend.lessons_tests.title')</h3>
            @can('lesson_create')
                <div class="float-right">
                    <a id="order_change" 
                       class="btn btn-primary" style="color:white">Order change</a>
                </div>
            @endcan
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('course_id', trans('labels.backend.lessons.fields.course'), ['class' => 'control-label']) !!}
                    {!! Form::select('course_id', $courses,  (request('course_id')) ? request('course_id') : old('course_id'), ['class' => 'form-control js-example-placeholder-single select2 ', 'id' => 'course_id']) !!}
                </div>
            </div>
            <div class="d-block">
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="{{ route('admin.lessons.index',['course_id'=>request('course_id')]) }}"
                           style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">{{trans('labels.general.all')}}</a>
                    </li>
                    |
                    <li class="list-inline-item">
                        <a href="{{trashUrl(request()) }}"
                           style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">{{trans('labels.general.trash')}}</a>
                    </li>
                </ul>
            </div>

            @if(request('course_id') != "" || request('show_deleted') != "")
                <div class="table-responsive">

                    <table id="myTable"
                           class="table table-bordered table-striped @can('lesson_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                        <thead>
                        <tr>
                            @can('lesson_delete')
                                @if ( request('show_deleted') != 1 )
                                    <th style="text-align:center;"><input class="mass" type="checkbox" id="select-all"/>
                                    </th>@endif
                            @endcan
                                <th>@lang('labels.general.sr_no')</th>

                                <th>@lang('labels.general.id')</th>
                                <th>@lang('labels.backend.lessons_tests.fields.type')</th>
                            <th>@lang('labels.backend.lessons.fields.title')</th>
                            <th>@lang('labels.backend.lessons_tests.fields.sequence')</th>
                        </tr>
                        </thead>
                        <tbody id="sortableLessons">
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

            
            $(function() {
                $('#sortableLessons').sortable({
                    update: function(event, ui) {
                    }
                });
            });

            $("#order_change").on('click',function(e){
                var course_id = $("#course_id").val();
                var sequenceValues = [];
                $('.sequence').each(function() {
                  var value = $(this).val();
                  sequenceValues.push(value);
                });
                var seq = JSON.stringify(sequenceValues)
                var order_info=[], id_info=[];
                for (var i=1;i<=$("#sortableLessons").children().length;i++)
                {
                    id_info[i-1] =$("#sortableLessons tr:nth-child("+i+")").find("td:eq(2)").text(); //id value
                    order_info[i-1] =$("#sortableLessons tr:nth-child("+i+")").find("td:eq(1)").text();// order value
                }
                e.preventDefault();
                    $.ajax({
                        data: { "test_id":"<?php echo request('test_id') ?? '' ?>", "id_info":JSON.stringify(id_info),"courseid":course_id,'sequence':JSON.stringify(order_info)},
                        url: '{{route('admin.courses.set_reorder_lesson_test')}}',
                        type: 'get',
                        dataType: 'json',
                        success: function(response){
                            swal("Success", response.success, "success")
                        },
                        error: function(response){
                            console.log("error");
                        }
                    });    
            });


            var route = '{{route('admin.courses.get_reorder_lesson_test_data')}}';


            @php
                $show_deleted = (request('show_deleted') == 1) ? 1 : 0;
                $course_id = (request('course_id') != "") ? request('course_id') : 0;
            $route = route('admin.courses.get_reorder_lesson_test_data',['show_deleted' => $show_deleted,'course_id' => $course_id]);
            @endphp

            route = '{{$route}}';
            route = route.replace(/&amp;/g, '&');

            @if(request('course_id') != "" || request('show_deleted') != "")

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
                            columns: [ 1, 2, 3, 4]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4]
                        }
                    },
                    'colvis'
                ],
                ajax: route,
                columns: [
                        @if(request('show_deleted') != 1)
                    {
                        "data": function (data) {
                            return '<input type="checkbox" class="single" name="id[]" value="' + data.id + '" /><input type="hidden" class="sequence" name="seq[]" value="' + data.sequence + '" />';
                        }, "orderable": false, "searchable": false, "name": "id"
                    },
                        @endif
                    {data: "DT_RowIndex", name: 'DT_RowIndex', searchable: false, orderable:false},
                    {data: "id", name: 'id'},
                    {data: "type", name: 'type'},
                    {data: "title", name: 'title'},
                    {data: "sequence", name: 'sequence',"orderable": true},
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
                placeholder: "{{trans('labels.backend.lessons.select_course')}}",
            });
            $(document).on('change', '#course_id', function (e) {
                var course_id = $(this).val();
                window.location.href = "{{route('admin.courses.reorder_lesson_test')}}" + "?course_id=" + course_id
            });
        });

    </script>
@endpush