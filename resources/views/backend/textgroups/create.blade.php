@extends('backend.layouts.app')
@section('title', __('labels.backend.textgroups.title').' | '.app_name())

@section('content')
     <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
    <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

    <style>
         #sortable-8{ list-style-type: none; margin: 0; 
            padding: 0; width: 25%; float:left;}
         #sortable-8 li{ margin: 0 3px 3px 3px; padding: 0.4em; 
            padding-left: 1.5em; font-size: 17px; height: 16px; }
         .default {
            background: #ccc;
            border: 1px solid #DDDDDD;
            color: #333333;
         }     
    </style>

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">Textgroup Edit</h3>
            <div class="float-right">
                <a href="{{ route('admin.textgroups.index') }}"
                   class="btn btn-success">@lang('labels.backend.textgroups.view')</a>
            </div>         
         
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('tests', 'Test', ['class' => 'control-label']) !!}
                 <?php 
                    $i=0;
                 ?>                 
                <select class="form-control select2 required" name="tests_id" id="tests_id" placeholder="Options" multiple>
                    @foreach($tests as $test)
                        @if ($i ==0)
                            <option value="{{$test->id}}" selected>{{ $test->title}}</option>
                                <?php
                                $i++;
                            ?>
                        @else
                            <option value="{{$test->id}}">{{$test->title}}</option>                             
                        @endif 
                    @endforeach  
                </select> 

                <div class="form-group form-md-line-input has-info" style="margin-top:20px;">
                    <input  id="title" type="text"  class="form-control" value="">
                    <label  class="control-label" >Input the title of textgroups</label>
                </div>
                 
                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">Textgroup</h3>           
        </div>
        <div  class="card-body row">
            <div class="edit col-12" id="textgroup_edit" >
                @for ($p=0;$p<10;$p++)
                <div class="row" id="text_{{$p}}">
                    <div class="col-12 form-group" id="content_{{ $p }}">
                       <div class="form-group form-md-line-input">                   
                            <textarea  id="textarea_{{ $p }}"  style="background-color:#ffcccc"   class="form-control" rows="2"></textarea>   
                             <label  class="control-label">text {{ $p+1 }}</label> 
                        </div>
                        <div class="form-group form-md-line-input has-error">
                            <input  id="score_{{ $p }}" type="text"  class="form-control" value="">  
                             <label  >Score</label>    
                        </div>      
                            
                    </div> 

                    <div class="col-12 form-group logic_part" id="logic_part_{{ $p }}">                    
                        <div class ="sortable-14">
                            <input type="hidden" class="logic_cnt" id="logic_cnt_{{ $p }}" value="1">
                           
                            @for($hh =0;$hh<10;$hh++)
                                <div class="row clone_condition logic_condition_{{ $hh }}" style="padding-top:10px;" >
                                        <div class="col-3">
                                            <select class="form-control btn-primary first_operator" name="first_operator" placeholder="Options">
                                                <option value="0">And</option>
                                                <option value="1">Or</option>
                                            </select>
                                        </div>
                                        <div class="col-4">                                            
                                            <input type="text" class="qt_name btn-success form-control" >
                    
                                            <div class="tree_3 tree-demo" display="none">
                                                <ul class="treecontent">
                                                    @for ($i=0;$i<count($course_list);$i++)
                                                    <li>                  
                                                    {{ $course_list[$i]['title'] }} </a>
                                                        <ul>
                                                            @for ($j=0;$j<count($course_test_list[$i]);$j++)
                                                                <li>
                                                                    {{ $course_test_list[$i][$j]['title']}}
                                                                    <ul>
                                                                        <?php
                                                                            $tk=  $course_test_list[$i][$j]['id'];
                                                                        ?>
                                                                        @if(isset($question_list[$tk]))
                                                                            @for ($k=0;$k<count($question_list[$tk]);$k++)
                                                                                <li>
                                                                                    {{ $question_list[$tk][$k]['id'] }}.{{ $question_list[$tk][$k]['question'] }}
                                                                                </li>
                                                                            @endfor
                                                                        @endif
                                                                    </ul>
                                                                </li>
                                                            @endfor
                                                        </ul>
                                                    </li>                                     
                                                    @endfor
                                                </ul>                   
                                            </div>
                                        </div>
                                        <input class="qt_type" type="hidden" value="">
                                        <div class="col-5">                                    
                                            <select class="form-control btn-warning operators" name="operators" placeholder="Options">
                                                <?php
                                                    $operators=["equals","not equals","contains","not contains","greater","less","greater or equals","less or equals"];
                                                ?>
                                                @for($i=0;$i<count($operators);$i++)
                                                    <option value="{{ $i }}">{{ $operators[$i] }}</option>
                                                @endfor                                       
                                            </select>
                                        </div>
                                        <div class="col-12 logic-content" style="padding-top:10px">
                                        </div>
                                        <div class="col-12" style="padding-top:10px;">                                            
                                            <a class="btn btn-xs  btn-danger del-btnx" style="cursor:pointer;"><i class="fa fa-trash" style="color:white"></i></a>
                                            <hr> 
                                        </div>

                                        
                                </div>

                                 
                            @endfor  
                             <div class="main-content" id="cond_0"></div>                              
                        </div>
                        <button class="btn btn-primary condition_add" style="margin-top:20px">Add Conditon</button>
                    </div>            
                        
                </div>  
                @endfor 

                
            </div>   
             <div class="float-left">
                <button class="btn btn-success" id="text_add" style="margin-left:30px">+ New Text</button>  
            </div>
        </div> 
       
    </div>
    <div class="float-right">
        <button class="btn btn-danger" id="save_data">Save Text</button>  
    </div>


    <script type="text/javascript" src="{{asset('js/select2.full.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/main.js')}}"></script>

    <script type="text/javascript" src="{{asset('js/ui-nestable.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.nestable.js')}}"></script>

    <!-- <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script> -->
    <script type="text/javascript" src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/dataTables.bootstrap.js')}}"></script>
    
    <script type="text/javascript" src="{{asset('js/table-editable.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/textgroup-create.js')}}"></script>

    <script src="{{ asset('assets/metronic_assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>


    <script type="text/javascript" src="{{asset('js/3.5.1/jquery.min.js')}}"></script>

    {{-- <link href="{{asset('css/custom.css')}}"  rel="stylesheet" type="text/css"/> --}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets/metronic_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}"/>   
    <script type="text/javascript" src="{{asset('assets/metronic_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}"></script>



    <script>  

        jQuery(document).ready(function(e) {       
            // initiate layout and plugins
            // Metronic.init(); // init metronic core components
            // Layout.init(); // init current layout
            // QuickSidebar.init(); // init quick sidebar
            // Demo.init(); // init demo features
            UITree.init();  
            //UINestable.init();
            //TableEditable.init();
            TextgroupCreate.init();  
            //UIToastr.init();  
        });
    </script>

    


    
@stop

