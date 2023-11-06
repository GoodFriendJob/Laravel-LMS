@inject('request', 'Illuminate\Http\Request')
@extends('backend.layouts.app')
@section('title', __('labels.backend.questions.title').' | '.app_name())

@section('content')

  <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
    <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <style>
        .page_no{
            background: #fff;
            border: 1px solid #000;
            color: #000 !important;
            text-shadow: none;
        }
       td p img {
    width: 50px !important;
    height: 50px !important;
}
td img {
    width: 50px !important;
    height: 50px !important;
}
    </style>
    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('labels.backend.questions.title')</h3>
            @can('question_create')
                <div class="float-right">
                   <a id="order_change" 
                       class="btn btn-primary" style="color:white">Order change</a>
                    <a href="{{ route('admin.questions.create') }}"
                       class="btn btn-success">Add New</a>

                </div>
            @endcan
        </div>
        <div class="card-body table-responsive">
            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('test_id', trans('labels.backend.questions.test'), ['class' => 'control-label']) !!}
                    {!! Form::select('test_id', $tests,  (request('test_id')) ? request('test_id') : old('test_id'), ['class' => 'form-control js-example-placeholder-single select2 ', 'id' => 'test_id']) !!}
                </div>
            </div>
            <div class="d-block">
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="{{ route('admin.questions.index') }}"
                                                    style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">{{trans('labels.general.all')}}</a>
                    </li>
                    |
                    <li class="list-inline-item"><a href="{{ route('admin.questions.index') }}?show_deleted=1"
                                                    style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">{{trans('labels.general.trash')}}</a>
                    </li>
                </ul>
            </div>
            <table id="myTable"
                   class="table table-bordered table-striped @if ( request('show_deleted') != 1 ) dt-select @endif ">
                <thead>
                <tr>
                    @can('question_delete')
                        @if ( request('show_deleted') != 1 )
                            <th style="text-align:center;"><input type="checkbox" class="mass" id="select-all"/></th>@endif
                    @endcan
                        <th>@lang('labels.general.sr_no')</th>
                        <th>@lang('labels.general.id')</th>
                        <th>Question Order</th>
                        @if(request('test_id') != "")
                        <th> Page No</th>
                        @endif
                        <th> @lang('labels.backend.questions.fields.question')</th>
                        <th>@lang('labels.backend.questions.fields.question_image')</th>
                        @if( request('show_deleted') == 1 )
                        <th>@lang('strings.backend.general.actions')</th>
                        @else
                        <th>@lang('strings.backend.general.actions')</th>
                        @endif
                        <th width="5%">condition logic</th>
                </tr>
                </thead>

                <tbody id="sortable-20">

                </tbody>
            </table>
        </div>
    </div>
@stop

@push('after-scripts')
  {{-- <script type="text/javascript" src="{{asset('js/3.5.1/jquery.min.js')}}"></script> --}}

<script>

        console.log("");

        jQuery(document).ready(function (e) {
           // QuestionEdit.init();
              $(function() {
                $('#sortable-20').sortable({
                    update: function(event, ui) {
                    }
                });
            });
           
            $("#order_change").on('click',function(e){
                var order_info=[], id_info=[];
                for (var i=1;i<=$("#sortable-20").children().length;i++)
                {
                
                    id_info[i-1] =$("#sortable-20 tr:nth-child("+i+")").find("td:eq(2)").text(); //id value
                    order_info[i-1] =$("#sortable-20 tr:nth-child("+i+")").find("td:eq(1)").text();// order value
                } 

                // alert(id_info);
                e.preventDefault();
                    $.ajax({
                        data: { "test_id":"<?php echo request('test_id') ?? '' ?>", "id_info":JSON.stringify(id_info)},
                        url: '{{route('user.questions.order-edit')}}',
                        type: 'get',
                        dataType: 'json',
                        success: function(response){
                            swal("Success", response.success, "success")
                        },
                        error: function(response){
                            console.log("error");
                        }
                    });    
            });


            var route = '{{route('admin.questions.get_data')}}';

            @if(request('show_deleted') == 1)
                route = '{{route('admin.questions.get_data',['show_deleted' => 1])}}';
            @endif

            @if(request('test_id') != "")
                route = '{{route('admin.questions.get_data',['test_id' => request('test_id')])}}';
            @endif

            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 25,
                lengthMenu: [ 25, 50, 75, 100 ],
                retrieve: true,
                dom: 'lfBrtip<"actions">',
                buttons: [
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [ 1, 2, 3, 5,]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [ 1, 2, 3, 5]
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
                    {data: "DT_RowIndex", name: 'DT_RowIndex', searchable: false, orderable: false},
                    {data: "id", name: 'id'},
                    {data: "questionorder", name: 'questionorder'},
                    @if(request('test_id') != "")
                    {data: "page_no", name: 'page_no'},
                    @endif
                    {data: "question", name: 'question'},
                    {data: "questionimage", name: 'questionimage'},                    
                    {data: "actions", name: "actions"},
                    {data: function(data){ 
                        return '<p style="background-color:gold">'+ data.conditionlogic +'</p>'
                        }    
                    }
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
                initComplete: function(settings, json){
                    $( ".page_no" ).blur(function() {
                        //console.log($(this).attr('id'));
                        //console.log($(this.val());
                        $.ajax({
                            data: { "test_id":"<?php echo request('test_id') ?? '' ?>", "question_id":$(this).attr('id'), "page_no":$(this).val(),"_token": "{{ csrf_token() }}"},
                            url: 'questions/page-update',
                            type: 'post',
                            dataType: 'json',
                            success: function(response){     
                                //alert("The Page Number is updated successfully.");
                            },
                            error: function(response){
                                console.log("error");
                            }
                        });
                    });
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
            $(document).on('change', '#test_id', function (e) {
                var course_id = $(this).val();
                window.location.href = "{{route('admin.questions.index')}}" + "?test_id=" + course_id;
            });
            @can('question_delete')
            @if(request('show_deleted') != 1)
            $('.actions').html('<a href="' + '{{ route('admin.questions.mass_destroy') }}' + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">Delete selected</a>');
            @endif
            @endcan



        });





    </script>
@endpush