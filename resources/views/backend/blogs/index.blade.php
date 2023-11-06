@inject('request', 'Illuminate\Http\Request')
@extends('backend.layouts.app')

@section('title', __('labels.backend.blogs.title').' | '.app_name())

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">@lang('labels.backend.blogs.title')</h3>
            @can('blog_create')
                <div class="float-right">
                    <a href="{{ route('admin.blogs.create') }}" class="btn btn-success">@lang('strings.backend.general.app_add_new')</a>
                </div>
            @endcan
        </div>
        <div class="card-body">

            <div class="table-responsive">

                <table id="myTable"
                       class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        @can('lesson_delete')
                            @if ( request('show_deleted') != 1 )
                                <th style="text-align:center;"><input class="mass" type="checkbox" id="select-all"/>
                                </th>@endif
                        @endcan
                        <th>@lang('labels.general.sr_no')</th>
                        <th>@lang('labels.general.id')</th>
                        <th>@lang('labels.backend.blogs.fields.title')</th>
                        <th>@lang('labels.backend.blogs.fields.category')</th>
                        <th>@lang('labels.backend.blogs.fields.created')</th>
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

        </div>
    </div>

@endsection

@push('after-scripts')
    <script>

        $(document).ready(function () {
            var route = '{{route('admin.blogs.get_data')}}';

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
                            return '<input type="checkbox" class="single" name="id[]" value="' + data.id + '" />';
                        }, "orderable": false, "searchable": false, "name": "id"
                    },
                        @endif
                    {data: "DT_RowIndex", name: 'DT_RowIndex', searchable: false},
                    {data: "id", name: 'id'},
                    {data: "title", name: 'title'},
                    {data: "category", name: 'category'},
                    {data: "created", name: "created"},
                    {data: "actions", name: "actions"}
                ],
                language:{
                    url : "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/{{$locale_full_name}}.json",
                    buttons :{
                        colvis : '{{trans("datatable.colvis")}}',
                        pdf : '{{trans("datatable.pdf")}}',
                        csv : '{{trans("datatable.csv")}}',
                    }
                },
                @if(request('show_deleted') != 1)
                columnDefs: [
                    {"width": "5%", "targets": 0},
                    {"className": "text-center", "targets": [0]}
                ],
                @endif

                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-entry-id', data.id);
                },
            });


            @can('blog_delete')
            @if(request('show_deleted') != 1)
            $('.actions').html('<a href="' + '{{ route('admin.blogs.mass_destroy') }}' + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">Delete selected</a>');
            @endif
            @endcan

        });

    </script>
@endpush