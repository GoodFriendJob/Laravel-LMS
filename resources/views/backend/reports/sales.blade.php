@extends('backend.layouts.app')

@section('title', __('labels.backend.reports.sales_report').' | '.app_name())

@push('after-styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">@lang('labels.backend.reports.sales_report')</h3>
        </div>
        <div class="card-body">
            <div class="row my-4">
                <div class="col-12">
                    <form autocomplete="off">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="date">@lang('labels.backend.reports.date_range')</label>
                                <input type="text" name="date" class="form-control" placeholder="" id="date" autocomplete="off" value="{{ request()->get('date') }}">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" name="applyDate" value="1" {{ request()->get('applyDate')?'checked': '' }}>
                                    <label class="form-check-label" for="applyDate">@lang('labels.backend.reports.apply_date')</label>
                                </div>
                            </div>
                            <div class="col">
                                <label for="students">@lang('labels.backend.reports.select_student')</label>
                                <select class="form-control select2" name="student">
                                    <option value="">@lang('labels.backend.reports.select_student')</option>
                                    @forelse($students as $student)
                                        <option value="{{ $student->id }}" @if(request()->get('student')) {{ request()->get('student') == $student->id ? 'selected': '' }} @endif>{{ $student->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="col">
                                <label for="students">@lang('labels.backend.reports.select_course')</label>
                                <select class="form-control select2" name="course">
                                    <option value="">@lang('labels.backend.reports.select_course')</option>
                                    @forelse($courses as $course)
                                        <option value="{{ $course->id }}" @if(request()->get('course')) {{ request()->get('course') == $course->id ? 'selected': '' }} @endif>{{ $course->title }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="col">
                                <label for="students">@lang('labels.backend.reports.select_bundle')</label>
                                <select class="form-control select2" name="bundle">
                                    <option value="">@lang('labels.backend.reports.select_bundle')</option>
                                    @forelse($bundles as $bundle)
                                        <option value="{{ $bundle->id }}" @if(request()->get('bundle')) {{ request()->get('bundle') == $bundle->id ? 'selected': '' }} @endif>{{ $bundle->title }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">@lang('labels.backend.reports.filter')</button>
                        <a class="btn btn-danger" href="{{ route('admin.reports.sales') }}">@lang('labels.backend.reports.reset')</a>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-5">
                    <div class="card text-white bg-primary text-center">
                        <div class="card-body">
                            <h2 class="">{{$appCurrency['symbol'].' '.$total_earnings}}</h2>
                            <h5>@lang('labels.backend.reports.total_earnings')</h5>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-5 ml-auto">
                    <div class="card text-white bg-success text-center">
                        <div class="card-body">
                            <h2 class="">{{$total_sales}}</h2>
                            <h5>@lang('labels.backend.reports.total_sales')</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h4>@lang('labels.backend.reports.courses')</h4>
                    <div class="table-responsive">
                        <table id="myCourseTable" class="table table-bordered table-striped ">
                            <thead>
                            <tr>
                                <th>@lang('labels.general.sr_no')</th>
                                <th>@lang('labels.general.id')</th>
                                <th>@lang('labels.backend.reports.fields.student')</th>
                                <th>@lang('labels.backend.reports.fields.name')</th>
                                <th>@lang('labels.backend.reports.fields.transaction')</th>
                                <th>@lang('labels.backend.reports.fields.amount') <span style="font-weight: lighter">(in {{$appCurrency['symbol']}})</span></th>
                                <th>@lang('labels.backend.reports.fields.date')</th>
                            </tr>
                            </thead>

                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12">
                    <h4>@lang('labels.backend.reports.bundles')</h4>
                    <div class="table-responsive">
                        <table id="myBundleTable" class="table table-bordered table-striped ">
                            <thead>
                            <tr>
                                <th>@lang('labels.general.sr_no')</th>
                                <th>@lang('labels.general.id')</th>
                                <th>@lang('labels.backend.reports.fields.student')</th>
                                <th>@lang('labels.backend.reports.fields.name')</th>
                                <th>@lang('labels.backend.reports.fields.transaction')</th>
                                <th>@lang('labels.backend.reports.fields.amount') <span style="font-weight: lighter">(in {{$appCurrency['symbol']}})</span></th>
                                <th>@lang('labels.backend.reports.fields.date')</th>
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>

        var queryParams= '';
        @if(request()->get('applyDate'))
            queryParams += "applyDate={{ request()->get('applyDate') }}&";
        @endif
        @if(request()->get('date'))
            queryParams += "date={{ request()->get('date') }}&";
        @endif
        @if(request()->get('student'))
            queryParams += "student={{ request()->get('student') }}&";
        @endif
        @if(request()->get('course'))
            queryParams += "course={{ request()->get('course') }}&";
        @endif
        @if(request()->get('bundle'))
            queryParams += "bundle={{ request()->get('bundle') }}";
        @endif

        $(document).ready(function () {
            var course_route = '{{route('admin.reports.get_course_data')}}?'+queryParams;
            var bundle_route = '{{route('admin.reports.get_bundle_data')}}?'+queryParams;

            $('#myCourseTable').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 10,
                retrieve: true,
                order: [
                    [5, 'desc']
                ],
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
                ajax: course_route,
                columns: [
                    {data: "DT_RowIndex", name: 'DT_RowIndex', width: '8%',  orderable: false, searchable: false},
                    {data: "id", name: 'id', width: '8%'},
                    {data: "student", name: 'order.user.name', orderable: false, searchable: false},
                    {data: "title", name: 'item.title', orderable: false, searchable: false},
                    {data: "transaction", name: 'order.transaction_id', orderable: false, searchable: false},
                    {data: "amount", name: 'order.amount', orderable: false, searchable: false},
                    {data: "created_at", name: 'created_at'},
                ],


                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-entry-id', data.id);
                },
            });

            $('#myBundleTable').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 10,
                retrieve: true,
                order: [
                    [5, 'desc']
                ],
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
                ajax: bundle_route,
                columns: [
                    {data: "DT_RowIndex", name: 'DT_RowIndex', width: '8%',  orderable: false, searchable: false},
                    {data: "id", name: 'id', width: '8%'},
                    {data: "student", name: 'order.user.name', orderable: false, searchable: false},
                    {data: "title", name: 'item.title', orderable: false, searchable: false},
                    {data: "transaction", name: 'order.transaction_id', orderable: false, searchable: false},
                    {data: "amount", name: 'order.amount', orderable: false, searchable: false},
                    {data: "created_at", name: 'created_at'},
                ],
                language:{
                    url : "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/{{$locale_full_name}}.json",
                    buttons :{
                        colvis : '{{trans("datatable.colvis")}}',
                        pdf : '{{trans("datatable.pdf")}}',
                        csv : '{{trans("datatable.csv")}}',
                    }
                },


                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-entry-id', data.id);
                },
            });
        });

        $('#date').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD',
                separator: ' / '
            },
            ranges: {
                '{{ trans('labels.backend.reports.date_input_lang.today') }}': [moment(), moment()],
                '{{ trans('labels.backend.reports.date_input_lang.yesterday') }}': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '{{ trans('labels.backend.reports.date_input_lang.last_7_days') }}': [moment().subtract(6, 'days'), moment()],
                '{{ trans('labels.backend.reports.date_input_lang.last_30_days') }}': [moment().subtract(29, 'days'), moment()],
                '{{ trans('labels.backend.reports.date_input_lang.this_month') }}': [moment().startOf('month'), moment().endOf('month')],
                '{{ trans('labels.backend.reports.date_input_lang.last_month') }}': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                '{{ trans('labels.backend.reports.date_input_lang.quarter_to_date') }}': [moment().startOf('quarter'), moment()],
                '{{ trans('labels.backend.reports.date_input_lang.year_to_date') }}': [moment().startOf('year'), moment()],
            },
            opens: "left",
        }, function(start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });

    </script>

@endpush
