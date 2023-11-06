@inject('request', 'Illuminate\Http\Request')
@extends('backend.layouts.app')
@section('title', __('labels.backend.courses.title').' | '.app_name())

@section('content')


    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('menus.backend.sidebar.timelimmit.title')</h3>
            @can('course_create')
                <div class="float-right">
                    <a href="{{ route('admin.time_limit_crate') }}"
                       class="btn btn-success">@lang('strings.backend.general.app_add_new')</a>
                </div>
            @endcan
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="d-block">
                    <!-- <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="{{ route('admin.courses.index') }}"
                               style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">{{trans('labels.general.all')}}</a>
                        </li>
                        |
                        <li class="list-inline-item">
                            <a href="{{ route('admin.courses.index') }}?show_deleted=1"
                               style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">{{trans('labels.general.trash')}}</a>
                        </li>
                    </ul> -->
                </div>


                <table id="myTable" class="table table-bordered table-striped @can('course_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                    <thead>
                    <tr>
                       
                        <th>@lang('labels.backend.courses.fields.user_name')</th>
                        <th>@lang('labels.backend.courses.fields.time_limit')</th>
                        <!-- @if(request('show_deleted') == 1 )
                            <th>&nbsp; @lang('strings.backend.general.actions')</th>
                        @else
                            <th>&nbsp; @lang('strings.backend.general.actions')</th>
                        @endif -->
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

            var route = '{{route('admin.timelimit.getData')}}';
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
                            columns: [ 1, 2, 3, 4,5,6 ]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4,5,6 ]
                        }
                    },
                    'colvis'
                ],
                ajax: route,
                columns: [
                    {data: "user_name", name: "username"},
                    {data: "time_limit", name: "time limit"},
                    // {data: "actions", name: "actions"}
                ],
                
            });
            
        });

    </script>

@endpush