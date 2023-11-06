@extends('backend.layouts.app')
@section('title', __('labels.backend.sponsors.title').' | '.app_name())

@section('content')

    <div class="card">
        <div class="card-header">
            @if(isset($sponsor))
            <h3 class="page-title d-inline">@lang('labels.backend.sponsors.edit')</h3>
                <div class="float-right">
                    <a href="{{ route('admin.sponsors.index') }}"
                       class="btn btn-success">@lang('labels.backend.sponsors.view')</a>
                </div>
            @else
                <h3 class="page-title d-inline">@lang('labels.backend.sponsors.create')</h3>
                <div class="float-right">
                    <a data-toggle="collapse" id="createCatBtn" data-target="#createCat" href="#"
                       class="btn btn-success">@lang('strings.backend.general.app_add_new')</a>

                </div>
            @endif

        </div>
        <div class="card-body">
            <div class="row @if(!isset($sponsor)) collapse @endif" id="createCat">
                <div class="col-12">
                    @if(isset($sponsor))
                        {!! Form::model($sponsor, ['method' => 'PUT', 'route' => ['admin.sponsors.update', $sponsor->id], 'files' => true,]) !!}
                    @else
                        {!! Form::open(['method' => 'POST', 'route' => ['admin.sponsors.store'], 'files' => true,]) !!}
                    @endif

                    <div class="row">
                        <div class="col-lg-4 col-12 form-group mb-0">
                            {!! Form::label('name', trans('labels.backend.sponsors.fields.name').' *', ['class' => 'control-label']) !!}
                            {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.sponsors.fields.name'), 'required' => false]) !!}

                        </div>
                        <div class="col-lg-4 col-12 form-group mb-0">
                            {!! Form::label('link', trans('labels.backend.sponsors.fields.link'), ['class' => 'control-label']) !!}
                            {!! Form::text('link', old('link'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.sponsors.fields.link'), 'required' => false]) !!}
                        </div>

                        <div class="col-lg-4 col-12 form-group mb-0">

                            {!! Form::label('logo',  trans('labels.backend.sponsors.fields.logo'), ['class' => 'control-label d-block']) !!}
                            @if(isset($sponsor) && ($sponsor->logo != null))
                                {!! Form::file('logo', ['class' => 'form-control w-75 d-inline-block', 'placeholder' => '', 'accept' => 'image/jpeg,image/gif,image/png']) !!}
                                    <img class="d-inline-block" src="{{asset('storage/uploads/'.$sponsor->logo)}}" height="38px">
                            @else
                                {!! Form::file('logo', ['class' => 'form-control d-inline-block', 'placeholder' => '']) !!}
                            @endif
                        </div>
                        <div class="col-12 form-group mt-3 text-center  mb-0 ">

                            {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn mt-auto  btn-danger']) !!}
                        </div>
                    </div>

                    {!! Form::close() !!}
                        <hr>


                </div>

            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <div class="d-block">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="{{ route('admin.sponsors.index') }}"
                                       style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">{{trans('labels.general.all')}}</a>
                                </li>
                                |
                                <li class="list-inline-item">
                                    <a href="{{ route('admin.sponsors.index') }}?show_deleted=1"
                                       style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">{{trans('labels.general.trash')}}</a>
                                </li>
                            </ul>
                        </div>


                        <table id="myTable"
                               class="table table-bordered table-striped @can('category_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                            <thead>
                            <tr>

                                @can('category_delete')
                                    @if ( request('show_deleted') != 1 )
                                        <th style="text-align:center;"><input type="checkbox" class="mass"
                                                                              id="select-all"/>
                                        </th>@endif
                                @endcan

                                <th>@lang('labels.general.sr_no')</th>
                                <th>@lang('labels.general.id')</th>
                                <th>@lang('labels.backend.sponsors.fields.name')</th>
                                <th>@lang('labels.backend.sponsors.fields.logo')</th>
                                <th>@lang('labels.backend.sponsors.fields.link')</th>
                                <th>@lang('labels.backend.sponsors.fields.status')</th>
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
        </div>
    </div>

@stop

@push('after-scripts')
    <script>

        $(document).ready(function () {
            var route = '{{route('admin.sponsors.get_data')}}';

            @if(request('show_deleted') == 1)
                route = '{{route('admin.sponsors.get_data',['show_deleted' => 1])}}';
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
                    {data: "name", name: 'name'},
                    {data: "logo", name: 'logo'},
                    {data: "link", name: "link"},
                    {data: "status", name: "status"},
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
            $('.actions').html('<a href="' + '{{ route('admin.sponsors.mass_destroy') }}' + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">Delete selected</a>');


            @if(request()->has('create'))
                $('#createCatBtn').click();
            @endif
        });

        $(document).on('click', '.switch-input', function (e) {
            var id = $(this).data('id');
            $.ajax({
                type: "POST",
                url: "{{ route('admin.sponsors.status') }}",
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