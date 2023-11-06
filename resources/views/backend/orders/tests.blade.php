@inject('request', 'Illuminate\Http\Request')
@extends('backend.layouts.app')
@section('title', __('labels.backend.tests.title').' | '.app_name())

@section('content')


    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">@lang('labels.backend.tests.title')</h3>
        </div>
        <div class="card-body table-responsive">
            
            @if(request('course_id') != "" || request('show_deleted') == 1)


            <table id="myTable"
                   class="table table-bordered table-striped @can('test_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead>
                <tr>
                    @can('test_delete')
                        @if ( request('show_deleted') != 1 )
                            <th style="text-align:center;"><input type="checkbox" class="mass" id="select-all"/>
                            </th>@endif
                    @endcan
                    <th>@lang('labels.general.sr_no')</th>
                    <th>@lang('labels.general.id')</th>
                    <th>@lang('labels.backend.tests.fields.course')</th>
                    <th>@lang('labels.backend.tests.fields.title')</th>
                    <th>@lang('labels.backend.tests.fields.questions')</th>
                    <th>@lang('labels.backend.tests.fields.published')</th>
                </tr>
                </thead>

                <tbody id='shotingTest'>

                </tbody>
            </table>
            @endif
        </div>
    </div>
@stop

@push('after-scripts')
    <script>

        $(document).ready(function () {
            
            $(function() {
                $('#shotingTest').sortable({
                    update: function(event, ui) {
                    }
                });
            });
           

            var route = '{{route('admin.orders.get_tests_by_course')}}';

            @php
                
                $course_id = (request('course_id') != "") ? request('course_id') : 0;
            $route = route('admin.orders.get_tests_by_course',['user_id'=> request('user_id'), 'course_id' => $course_id]);
            @endphp

            route = '{{$route}}';
            route = route.replace(/&amp;/g, '&');

            @if(request('show_deleted') == 1 ||  request('course_id') != "")

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
                            columns: [ 1, 2, 3, 4,5,6]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4,5,6]
                        }
                    },
                    'colvis'
                ],
                ajax: route,
                columns: [
                        @if(request('show_deleted') != 1)
                    {
                        "data": function (data) {
                            return '<input type="checkbox" class="single" name="id[]" value="' + data.id + '" />';
                        }, "orderable": false, "searchable": false, "name": "id"
                    },
                        @endif
                    {data: "DT_RowIndex", name: 'DT_RowIndex', searchable: false, orderable: false},
                    {data: "id", name: 'id'},
                    {data: "course", name: 'course'},
                    {data: "title", name: 'title'},
                    {data: "questions", name: "questions"},
                    {data: "published", name: "published"},
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

        });

    </script>

@endpush