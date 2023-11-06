@inject('request', 'Illuminate\Http\Request')
@extends('backend.layouts.app')
@section('title', __('labels.backend.testimonials.title').' | '.app_name())

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('labels.backend.testimonials.title')</h3>
                <div class="float-right">
                    <a href="{{ route('admin.testimonials.create') }}"
                       class="btn btn-success">@lang('strings.backend.general.app_add_new')</a>

                </div>
        </div>
        <div class="card-body table-responsive">

            <table id="myTable"
                   class="table table-bordered table-striped">
                <thead>
                <tr>
                    @can('question_delete')
                        @if ( request('show_deleted') != 1 )
                            <th style="text-align:center;"><input type="checkbox" class="mass" id="select-all"/></th>@endif
                    @endcan
                        <th>@lang('labels.general.sr_no')</th>
                        <th>@lang('labels.general.id')</th>
                        <th>@lang('labels.backend.testimonials.fields.name')</th>
                    <th>@lang('labels.backend.testimonials.fields.occupation')</th>
                    <th>@lang('labels.backend.testimonials.fields.content')</th>
                    <th>@lang('labels.backend.testimonials.fields.status')</th>
                    @if( request('show_deleted') == 1 )
                        <th>@lang('strings.backend.general.actions')</th>
                    @else
                        <th>@lang('strings.backend.general.actions')</th>
                    @endif
                </tr>
                </thead>

                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@stop

@push('after-scripts')
    <script>

        $(document).ready(function () {
            var route = '{{route('admin.testimonials.get_data')}}';

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
                        @if(request('show_deleted') != 1)
                    { "data": function(data){
                        return '<input type="checkbox" class="single" name="id[]" value="'+ data.id +'" />';
                    }, "orderable": false, "searchable":false, "name":"id" },
                        @endif
                    {data: "DT_RowIndex", name: 'DT_RowIndex', searchable: false},
                    {data: "id", name: 'id'},
                    {data: "name", name: 'name'},
                    {data: "occupation", name: 'occupation'},
                    {data: "content", name: 'content'},
                    {data: "status", name: 'status'},
                    {data: "actions", name: "actions"}
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

            @can('question_delete')
            @if(request('show_deleted') != 1)
            $('.actions').html('<a href="' + '{{ route('admin.testimonials.mass_destroy') }}' + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">Delete selected</a>');
            @endif
            @endcan

        });

        $(document).on('click', '.switch-input', function (e) {
            var id = $(this).data('id');
            $.ajax({
                type: "POST",
                url: "{{ route('admin.testimonials.status') }}",
                data: {
                    _token:'{{ csrf_token() }}',
                    id: id,
                },
            }).done(function() {
                var table = $('#myTable').DataTable();
		        table.ajax.reload();
            });
        })

    </script>
@endpush