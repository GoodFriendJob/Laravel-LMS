@inject('request', 'Illuminate\Http\Request')
@extends('backend.layouts.app')
@section('title', __('labels.backend.stripe.plan.title').' | '.app_name())

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">@lang('labels.backend.stripe.plan.title')</h3>
            @can('stripe_plan_create')
                <div class="float-right">
                    <a href="{{ route('admin.stripe.plans.create') }}"
                       class="btn btn-success">@lang('strings.backend.general.app_add_new')</a>

                </div>
            @endcan
        </div>
        <div class="card-body">
                <div class="table-responsive">
                    <div class="d-block">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a href="{{ route('admin.stripe.plans.index') }}"
                                   style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">{{trans('labels.general.all')}}</a>
                            </li>
                            @can('course_delete')
                                |
                                <li class="list-inline-item">
                                    <a href="{{ route('admin.stripe.plans.index') }}?show_deleted=1"
                                       style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">{{trans('labels.general.trash')}}</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                    <table id="myTable"
                           class="table table-bordered table-striped @can('stripe_plan_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                        <thead>
                        <tr>
                            <th>@lang('labels.general.sr_no')</th>

                            <th>@lang('labels.backend.stripe.plan.fields.name')</th>
                            <th>@lang('labels.backend.stripe.plan.fields.amount')</th>
                            <th>@lang('labels.backend.stripe.plan.fields.interval')</th>
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

@stop

@push('after-scripts')
    <script>

        $(document).ready(function () {
            var route = '{{route('admin.stripe.plans.get_data')}}';


            @php
            $show_deleted = (request('show_deleted') == 1) ? 1 : 0;
            $route = route('admin.stripe.plans.get_data',['show_deleted' => $show_deleted]);
            @endphp

            route = '{{$route}}';
            route = route.replace(/&amp;/g, '&');


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
                    {data: "name", name: 'name'},
                    {data: "amount", name: 'amount', searchable: false, orderable:false},
                    {data: "interval", name: 'interval', searchable: false, orderable:false},
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
        });

    </script>
@endpush
