@extends('backend.layouts.app')

@section('title', __('labels.backend.hero_slider.title').' | '.app_name())

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
            <h3 class="page-title d-inline">@lang('labels.backend.hero_slider.title')</h3>
            <div class="float-right">
                <a href="{{ route('admin.sliders.create') }}"
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
                                <th>@lang('labels.backend.hero_slider.fields.name')</th>
                                <th>@lang('labels.backend.hero_slider.fields.bg_image')</th>
                                <th>@lang('labels.backend.hero_slider.fields.sequence')</th>
                                <th>@lang('labels.backend.hero_slider.fields.status')</th>
                                @if( request('show_deleted') == 1 )
                                    <th>&nbsp; @lang('strings.backend.general.actions')</th>
                                @else
                                    <th>&nbsp; @lang('strings.backend.general.actions')</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($slides_list as $key=>$item)
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
                                        <img src="{{asset('storage/uploads/'.$item->bg_image)}}" height="50px">
                                    </td>
                                    <td>
                                        {{ $item->sequence }}
                                    </td>
                                    <td>
                                        {{
                                            html()->label(html()->checkbox('')->id($item->id)
                ->checked(($item->status == 1) ? true : false)->class('switch-input')->attribute('data-id', $item->id)->value(($item->status == 1) ? 1 : 0).'<span class="switch-label"></span><span class="switch-handle"></span>')->class('switch switch-lg switch-3d switch-primary')
                                        }}
                                        {{-- @if($item->status == 1)
                                            @lang('labels.backend.hero_slider.on')
                                        @else
                                            @lang('labels.backend.hero_slider.off')
                                        @endif --}}
                                    </td>
                                    <td>


                                        <a href="{{route('admin.sliders.edit',['slider'=>$item->id]) }}"
                                           class="btn btn-xs btn-info mb-1"><i class="icon-pencil"></i></a>

                                        <a data-method="delete" data-trans-button-cancel="Cancel"
                                           data-trans-button-confirm="Delete" data-trans-title="Are you sure?"
                                           class="btn btn-xs btn-danger text-white mb-1" style="cursor:pointer;"
                                           onclick="$(this).find('form').submit();">
                                            <i class="fa fa-trash"
                                               data-toggle="tooltip"
                                               data-placement="top" title=""
                                               data-original-title="Delete"></i>
                                            <form action="{{route('admin.sliders.destroy',['slider'=>$item->id])}}"
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

    <div class="card">
        <div class="card-header">
            <h3>@lang('labels.backend.hero_slider.manage_sequence')</h3>
        </div>
        <div class="card-body">
            @if(count($slides_list) > 0)
                <div class="row justify-content-center">
                    <div class="col-6  ">
                        <h4 class="">@lang('labels.backend.hero_slider.sequence_note')</h4>
                        <ul class="sorter d-inline-block">
                            @foreach($slides_list as $item)
                                <li>
                            <span data-id="{{$item->id}}" data-sequence="{{$item->sequence}}">

                                <p class="title d-inline ml-2">{{$item->name}}</p>
                           </span>

                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('admin.courses.index') }}"
                           class="btn btn-default border float-left">@lang('strings.backend.general.app_back_to_list')</a>

                        <a href="#" id="save_timeline"
                           class="btn btn-primary float-right">@lang('labels.backend.hero_slider.save_sequence')</a>

                    </div>

                </div>
            @endif
        </div>
    </div>

@endsection

@push('after-scripts')
    <script src="{{asset('plugins/amigo-sorter/js/amigo-sorter.min.js')}}"></script>

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
                            columns: [ 0,1, 2, 4]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [ 0,1, 2, 4]
                        }
                    },
                    'colvis'
                ],

                columnDefs: [
                    {"width": "10%", "targets": 0},
                    {"width": "15%", "targets": 4},
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

        $('ul.sorter').amigoSorter({
            li_helper: "li_helper",
            li_empty: "empty",
        });
        $(document).on('click', '#save_timeline', function (e) {
            e.preventDefault();
            var list = [];
            $('ul.sorter li').each(function (key, value) {
                key++;
                var val = $(value).find('span').data('id');
                list.push({id: val, sequence: key});
            });

            $.ajax({
                method: 'POST',
                url: "{{route('admin.sliders.saveSequence')}}",
                data: {
                    _token: '{{csrf_token()}}',
                    list: list
                }
            }).done(function () {
                location.reload();
            });
        })

        $(document).on('click', '.switch-input', function (e) {
            var id = $(this).data('id');
            $.ajax({
                type: "POST",
                url: "{{ route('admin.sliders.status') }}",
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

