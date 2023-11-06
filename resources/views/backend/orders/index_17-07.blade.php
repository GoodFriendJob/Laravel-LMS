@inject('request', 'Illuminate\Http\Request')
@extends('backend.layouts.app')
@section('title', __('labels.backend.orders.title').' | '.app_name())


@section('content')


    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline mb-0">@lang('labels.backend.orders.title')</h3>

        </div>
        <div class="card-body">
            <div class="d-block">
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="{{ route('admin.orders.index') }}"
                           style="{{ request('offline_requests') == 1 ? '' : 'font-weight: 700' }}">{{trans('labels.general.all')}}</a>
                    </li>
                    |
                    <li class="list-inline-item">
                        <a href="{{ route('admin.orders.index') }}?offline_requests=1"
                           style="{{ request('offline_requests') == 1 ? 'font-weight: 700' : '' }}">{{trans('labels.backend.orders.offline_requests')}}</a>
                    </li>
                </ul>
            </div>
            <div class="table-responsive">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th style="text-align:center;">
                            <input type="checkbox" class="mass" id="select-all"/>
                        </th>
                        <th>@lang('labels.general.sr_no')</th>
                        <th>@lang('labels.general.id')</th>
                        <th>@lang('labels.backend.orders.fields.reference_no')</th>
                        <th>@lang('labels.backend.orders.fields.items')</th>
                        <th>@lang('labels.backend.orders.fields.amount') <small>(in {{$appCurrency['symbol']}})</small></th>
                        <th>@lang('labels.backend.orders.fields.payment_status.title')</th>
                        <th>@lang('labels.backend.orders.fields.user_email')</th>
                        <th>@lang('labels.backend.orders.fields.date')</th>
                        <th>&nbsp; @lang('strings.backend.general.actions')</th>
                        
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@push('after-scripts')
    <script>
        $(document).ready(function () {
            var route = '{{route('admin.orders.get_data')}}';

            @if(request('offline_requests') == 1)
                route = '{{route('admin.orders.get_data',['offline_requests' => 1])}}';
            @endif

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
                            columns: [ 1, 2, 3, 4, 5, 6, 7,8 ]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4, 5, 6, 7,8 ]
                        }
                    },
                    'colvis'
                ],
                ajax: route,
                columns: [
                    {
                        data: function (data) {
                            return '<input type="checkbox" class="single" name="id[]" value="' + data.id + '" />';
                        }, "orderable": false, "searchable": false, "name": "id"
                    },
                    {data: "DT_RowIndex", name: 'DT_RowIndex', searchable: false},
                    {data: "id", name: 'id'},
                    {data: "reference_no", name: 'reference_no'},
                    {data: "items", name: 'items'},
                    {data: "amount", name: 'amount'},
                    {data: "payment", name: 'payment'},
                    {data: "user_email", name: 'user_email'},
                    {data: "date", name: "date"},
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
            @can('course_delete')
            @if(request('show_deleted') != 1)
            $('.actions').html('<a href="' + '{{ route('admin.orders.mass_destroy') }}' + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">Delete selected</a>');
            @endif
            @endcan
        });
    </script>
@endpush