@extends('backend.layouts.app')

@section('title', __('labels.backend.reasons.title').' | '.app_name())
@push('after-styles')
    <link rel="stylesheet" href="{{asset('assets/css/colors/switch.css')}}">
@endpush

@section('content')

    <div class="card">
        <div class="card-header">

                <h3 class="page-title d-inline">@lang('labels.backend.reasons.title')</h3>
                <div class="float-right">
                    <a href="{{ route('admin.reasons.create') }}"
                       class="btn btn-success">@lang('strings.backend.general.app_add_new')</a>
                </div>

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        {{--<div class="d-block">--}}
                            {{--<ul class="list-inline">--}}
                                {{--<li class="list-inline-item">--}}
                                    {{--<a href="{{ route('admin.reasons.index') }}"--}}
                                       {{--style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">{{trans('labels.general.all')}}</a>--}}
                                {{--</li>--}}
                                {{--|--}}
                                {{--<li class="list-inline-item">--}}
                                    {{--<a href="{{ route('admin.reasons.index') }}?show_deleted=1"--}}
                                       {{--style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">{{trans('labels.general.trash')}}</a>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}


                        <table id="myTable"
                               class="table table-bordered table-striped @can('category_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                            <thead>
                            <tr>

                                @can('category_delete')
                                    @if ( request('show_deleted') != 1 )
                                        <th style="text-align:center;">
                                            <input type="checkbox" class="mass" id="select-all"/>
                                        </th>
                                    @endif
                                @endcan

                                <th>@lang('labels.general.sr_no')</th>
                                <th>@lang('labels.general.id')</th>
                                <th>@lang('labels.backend.reasons.fields.title')</th>
                                <th>@lang('labels.backend.reasons.fields.icon')</th>
                                <th>@lang('labels.backend.reasons.fields.content')</th>
                                <th>@lang('labels.backend.reasons.fields.status')</th>
                                @if( request('show_deleted') == 1 )
                                    <th>&nbsp; @lang('strings.backend.general.actions')</th>
                                @else
                                    <th>&nbsp; @lang('strings.backend.general.actions')</th>
                                @endif
                            </tr>
                            </thead>

                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
            <hr>
            <h4>@lang('labels.backend.reasons.note')</h4>
            <img src="{{asset('images/reasons.jpg')}}" width="100%"  >


        </div>
    </div>

@stop

@push('after-scripts')
    <script>

        $(document).ready(function () {
            var route = '{{route('admin.reasons.get_data')}}';

            @if(request('show_deleted') == 1)
                route = '{{route('admin.reasons.get_data',['show_deleted' => 1])}}';
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
                            columns: [ 1, 2, 3,5]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [ 1, 2, 3,5]
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
                    {data: "icon", name: 'icon'},
                    {data: "content", name: 'content'},
                    {data: "status", name: 'Status'},
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

        });

        $(document).on('click', '.switch-input', function (e) {
            var id = $(this).data('id');
            $.ajax({
                type: "POST",
                url: "{{ route('admin.reasons.status') }}",
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