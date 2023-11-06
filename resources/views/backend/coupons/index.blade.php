@extends('backend.layouts.app')

@section('title', __('labels.backend.coupons.title').' | '.app_name())

@push('after-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/amigo-sorter/css/theme-default.css')}}">
    <style>
        ul.sorter > span {
            display: inline-block;
            width: 100%;
            height: 100%;
            background: #f5f5f5;
            color: #333333;
            border: 1px solid #cccccc;
            border-radius: 6px;
            padding: 0px;
        }

        ul.sorter li > span .title {
            padding-left: 15px;
        }

        ul.sorter li > span .btn {
            width: 20%;
        }


    </style>
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">@lang('labels.backend.coupons.title')</h3>
            <div class="float-right">
                <a href="{{ route('admin.coupons.create') }}"
                   class="btn btn-success">@lang('strings.backend.general.app_add_new')</a>

            </div>
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
                                <th>@lang('labels.backend.coupons.fields.name')</th>
                                <th>@lang('labels.backend.coupons.fields.code')</th>
                                <th>@lang('labels.backend.coupons.fields.type')</th>
                                <th>@lang('labels.backend.coupons.fields.amount')</th>
                                <th>@lang('labels.backend.coupons.fields.expires_at')</th>
                                {{--<th>@lang('labels.backend.coupons.fields.per_user_limit')</th>--}}
                                {{--<th>@lang('labels.backend.coupons.fields.total')</th>--}}
                                <th>@lang('labels.backend.coupons.fields.status')</th>
                                @if( request('show_deleted') == 1 )
                                    <th>&nbsp; @lang('strings.backend.general.actions')</th>
                                @else
                                    <th>&nbsp; @lang('strings.backend.general.actions')</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($coupons as $key=>$item)
                                @php $key++ @endphp
                                <tr>
                                    <td>
                                        {{ $key }}
                                    </td>
                                    <td>
                                        {{$item->id}}
                                    </td>
                                    <td>
                                        {{$item->name}}
                                    </td>

                                    <td>
                                        {{$item->code}}
                                    </td>
                                    <td>
                                        @if($item->type == 1)
                                            @lang('labels.backend.coupons.discount_rate') (in %)
                                        @else
                                            @lang('labels.backend.coupons.flat_rate') ( in {{config('app.currency')}})
                                        @endif
                                    </td>
                                    <td>
                                        {{$item->amount}}
                                    </td>
                                    <td>
                                        @if($item->expires_at)
                                            {{\Illuminate\Support\Carbon::parse($item->expires_at)->format('d M Y')}}
                                        @else
                                            @lang('labels.backend.coupons.unlimited')
                                        @endif
                                    </td>
                                    {{--<td>--}}
                                        {{--{{$item->per_user_limit}}--}}
                                    {{--</td>--}}
                                    {{--<td>--}}
                                        {{--{{$item->total}}--}}
                                    {{--</td>--}}
                                    <td>
                                        {{
                                            html()->label(html()->checkbox('')->id($item->id)
                ->checked(($item->status == 1) ? true : false)->class('switch-input')->attribute('data-id', $item->id)->value(($item->status == 1) ? 1 : 0).'<span class="switch-label"></span><span class="switch-handle"></span>')->class('switch switch-lg switch-3d switch-primary')
                                        }}
                                    </td>
                                    <td>
                                        <a href="{{route('admin.coupons.show',['coupon'=>$item->id]) }}"
                                               class="btn btn-xs btn-primary mb-1"><i class="icon-eye"></i></a>


                                        <a href="{{route('admin.coupons.edit',['coupon'=>$item->id]) }}"
                                           class="btn btn-xs btn-info mb-1"><i class="icon-pencil"></i></a>

                                        <a data-method="delete" data-trans-button-cancel="Cancel"
                                           data-trans-button-confirm="Delete" data-trans-title="Are you sure?"
                                           class="btn btn-xs btn-danger text-white mb-1" style="cursor:pointer;"
                                           onclick="$(this).find('form').submit();">
                                            <i class="fa fa-trash"
                                               data-toggle="tooltip"
                                               data-placement="top" title=""
                                               data-original-title="Delete"></i>
                                            <form action="{{route('admin.coupons.destroy',['coupon'=>$item->id])}}"
                                                  method="POST" name="delete_item" style="display:none">
                                                @csrf
                                                {{method_field('DELETE')}}
                                            </form>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('after-scripts')

    <script>


        $(document).ready(function () {

            $('#myTable').DataTable({
                processing: true,
                serverSide: false,
                iDisplayLength: 10,
                retrieve: true,
                dom: 'lfBrtip<"actions">',
                buttons: [
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [ 0,1,2,3,4,5,6]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [ 0,1,2,3,4,5,6]
                        }
                    },
                    'colvis'
                ],

                columnDefs: [
                    {"width": "5%", "targets": 0},
                    {"className": "text-center", "targets": [0]}
                ],
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
                url: "{{ route('admin.coupons.status') }}",
                data: {
                    _token:'{{ csrf_token() }}',
                    id: id,
                },
            }).done(function() {
               location.reload();
            });
        })

    </script>
@endpush

