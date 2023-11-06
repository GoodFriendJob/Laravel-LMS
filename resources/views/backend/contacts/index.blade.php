@extends('backend.layouts.app')

@section('title', __('labels.backend.contacts.title').' | '.app_name())




@section('content')

    <div class="card">
        <div class="card-header">

                <h3 class="page-title d-inline">@lang('labels.backend.contacts.title')</h3>


        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">


                        <table id="myTable"
                               class="table table-bordered table-striped ">
                            <thead>
                            <tr>

                                <th>@lang('labels.general.sr_no')</th>
                                <th>@lang('labels.general.id')</th>
                                <th>@lang('labels.backend.contacts.fields.name')</th>
                                <th>@lang('labels.backend.contacts.fields.email')</th>
                                <th>@lang('labels.backend.contacts.fields.phone')</th>
                                <th>@lang('labels.backend.contacts.fields.message')</th>
                                <th>@lang('labels.backend.contacts.fields.time')</th>
                            </tr>
                            </thead>

                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@push('after-scripts')
    <script>

        $(document).ready(function () {
            var route = '{{route('admin.contact_requests.get_data')}}';

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
                            columns: ':visible',
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':visible',
                        }
                    },
                    'colvis'
                ],
                ajax: route,
                columns: [

                    {data: "DT_RowIndex", name: 'DT_RowIndex', searchable: false},
                    {data: "id", name: 'id'},
                    {data: "name", name: 'name'},
                    {data: "email", name: 'email'},
                    {data: "number", name: 'number'},
                    {data: "message", name: "message"},
                    {data: "created_at", name: "time"},
                ],
                @if(request('show_deleted') != 1)
                columnDefs: [
                    {"width": "5%", "targets": 0},
                    {"width": "15%", "targets": 5},
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

        });

    </script>

@endpush