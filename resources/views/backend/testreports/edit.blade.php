<?php 
    $report = (array) $testreport[0];
?>
@extends('backend.layouts.app')
@section('title', __('Test Report(Edit)').' | '.app_name())
     <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
    <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    {{-- <script src="https://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script> --}}
    
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/ckeditor.js"></script> --}}
    <script src="{{asset('vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
    {{-- <script src="{{asset('plugins/ckeditor-plugin/bootstraptable/dialogs/bootstrapTable.js')}}"></script> --}}
    
@push('after-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/custom.css')}}">
    <style>
        .select2-container--default .select2-selection--single {
            height: 35px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 35px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 35px;
        }

        .bootstrap-tagsinput {
            width: 100% !important;
            display: inline-block;
        }

        .bootstrap-tagsinput .tag {
            line-height: 1;
            margin-right: 2px;
            background-color: #2f353a;
            color: white;
            padding: 3px;
            border-radius: 3px;
        }
        #pie-chartdiv{
            left:200px;
        }
        #donut-chartdiv{
            left:200px;
        }
        #bar-chartdiv{
            left:200px;
        }
        #d3bar-chartdiv{
            left:200px;
        }


    </style>

@endpush

@section('content')

     {{--  <form method="post" action="{{route('ckeditor.store')}}" enctype="multipart/form-data">
                        @csrf  --}}
    {!! Form::hidden('model_id',0,['id'=>'lesson_id']) !!}

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">Creation Of Test Reports</h3>
            <div class="float-right">
                <a href="{{ route('admin.testreports.index') }}"
                   class="btn btn-success">@lang('labels.backend.lessons.view')</a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                {{--  <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('course_id', trans('labels.backend.lessons.fields.course'), ['class' => 'control-label']) !!}
                    {!! Form::select('course_id', $courses,  (request('course_id')) ? request('course_id') : old('course_id'), ['class' => 'form-control select2']) !!}
                </div>
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('title', trans('labels.backend.lessons.fields.title').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.lessons.fields.title'), 'required' => '']) !!}
                </div>  --}}
                <div class="col-12 form-group">
                    {!! Form::label('tests', 'Test', ['class' => 'control-label']) !!}
                    <?php 
                        $i=0;
                    ?>                 
                    <select class="form-control select2 required" name="tests_id" id="tests_id" placeholder="Options" multiple>
                       <?php
                            $test_flag=array(); $t =0;  $tp=0;
                        ?>
                        @foreach($tests as $test)
                                    <?php
                                         $test_flag[$tp] = 0;                   
                                    ?>
                             @foreach($current_tests as $current_test)                                
                                @if ($test->id == $current_test->test_id)
                                    <?php     
                                        $test_flag[$tp] = 1;             
                                    ?>                                   
                                @endif
                            @endforeach
                                <?php
                                    $tp ++; 
                                ?>
                        @endforeach 

                        @foreach($tests as $test)
                                @if ($test_flag[$t] == 1)
                                    <option value="{{$test->id}}" selected>{{ $test->title}}</option>
                                @else
                                    <option value="{{$test->id}}" >{{ $test->title}}</option>
                                @endif
                                <?php
                                    $t ++; 
                                ?>
                        @endforeach 
                    </select>
                    <?php
                        $preview_content = htmlspecialchars_decode(json_decode($testreport[0]->content));
                        $current_content = json_decode($testreport[0]->origin_content);
                    ?>
                    <input  id="id" name="id" type="hidden"  class="form-control" value="{{ $testreport[0]->id}}">
                    <div class="form-group form-md-line-input has-info" style="margin-top:20px;">
                        <input  id="title" type="text"  class="form-control" value="{{ $testreport[0]->title}}">
                        <label  class="control-label" >Input the title of Test Report</label>
                    </div>
                 
                </div>
            </div>

            <div class="row">
                <div class="col-12 form-group" id="editor">
                    {{--  {!! Form::label('full_text', trans('labels.backend.lessons.fields.full_text'), ['class' => 'control-label']) !!}  --}}
                    <textarea class="form-control" id="summary-ckeditor" name="summary">{{$current_content}}</textarea>
               
                </div>
                
            </div>

            <div class="row">

                <div class="col-12 col-lg-3 form-group">
                    <div class="checkbox">
                        
                        <label for="published" class="checkbox control-label font-weight-bold"><input name="published" type="checkbox" value="1" @if($testreport[0]->published) checked @endif>Published</label>                        
                    </div>
                </div>
                <div class="col-12  text-left form-group">
                    {{--  {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn  btn-danger']) !!}  --}}
                    <button class="btn btn-danger" id="save_data">Save</button>
                </div>
            </div>
        </div>
    </div>

   {{--  </form>  --}}

  
<div class="card">
    <div class="card-header">
        <h3 class="page-title float-left mb-0">Preview</h3>
    </div>
    <div class="card-body">                    
            <div id="preview">{!! $preview_content !!}</div>
    </div>
</div>   

@stop

@push('after-scripts')
    <script src="{{asset('plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
    <script src="{{asset('/vendor/laravel-filemanager/js/lfm.js')}}"></script>
    <script src="{{asset('js/testreport-create.js')}}"></script>    
    
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/material.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/kelly.js"></script>
    <script src='https://cdn.plot.ly/plotly-2.9.0.min.js'></script>
    <script src="{{asset('js/pie-chart.js')}}"></script>
    <script src="{{asset('js/bar-chart.js')}}"></script>
    <script src="{{asset('js/d3bar-chart.js')}}"></script>
    <script src="{{asset('js/donut-chart.js')}}"></script>    
    <script src="{{asset('js/horizontal-bar.js')}}"></script>
    <script src="{{asset('js/line-chart.js')}}"></script>
    <script src="{{asset('js/radar-chart.js')}}"></script>
    <script src="{{asset('js/polar-chart.js')}}"></script>
    <script src="{{asset('js/bubble-chart.js')}}"></script>
    <script src="{{asset('js/radar1-chart.js')}}"></script>
    <script src="{{asset('js/responsive-table.js')}}"></script>
    <script src="{{asset('js/sortable-table.js')}}"></script>
    <script src="{{asset('js/no-table-chart.js')}}"></script>
 
    <script src="{{ asset('js/report-edit.js') }}"></script>

    <script>
        // config.extraPlugins = 'bootstrapTable';
        CKEDITOR.plugins.addExternal( 'bootstraptable', '//localhost:8000/vendor/unisharp/laravel-ckeditor/plugins/table/dialogs/', 'table.js' );
        CKEDITOR.replace( 'summary-ckeditor', {
            height : 300,
            filebrowserUploadUrl: `{{route('admin.ckeditor_fileupload',['_token' => csrf_token() ])}}`,
            filebrowserUploadMethod: 'form',
            extraPlugins: 'font,widget,colorbutton,colordialog,justify',
        });
        $(document).ready(function(){
            ReportEdit.init();
        })
        
    </script>

@endpush
