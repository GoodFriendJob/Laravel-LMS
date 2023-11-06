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
            <input type="hidden" id="text_id" value="{{ $current_textgroup->id }}">
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
                    $current_content = json_decode($current_textgroup->content);
                    $current_logic = json_decode($current_textgroup->logic);
                    $current_score = json_decode($current_textgroup->score);
                ?>
                <div class="form-group form-md-line-input has-info" style="margin-top:20px">                
                    <input  id="title" type="text"  class="form-control" value=" {{ $current_textgroup->title }} ">
                    <label>Input the title of textgroups</label>
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
                @for ($p=0;$p<count($current_content);$p++)
                <div class="row" id="text_{{$p}}">
                    <div class="col-12 form-group" id="content_{{ $p }}">
                         <div class="form-group form-md-line-input">                   
                            <textarea  id="textarea_{{ $p }}"  style="background-color:#ffcccc"   class="form-control" rows="2">{{ $current_content[$p] }}</textarea>   
                             <label  class="control-label">text {{ $p+1 }}</label> 
                        </div>
                        <div class="form-group form-md-line-input has-error">
                            <input  id="score_{{ $p }}" type="text"  class="form-control" value="{{ $current_score[$p] }}">  
                             <label  >Score</label>    
                        </div>         
                    </div> 

                    <div class="col-12 form-group logic_part" id="logic_part_{{ $p }}">
                        <div class ="sortable-14">
                            <input type="hidden" class="logic_cnt" id="logic_cnt_{{ $p }}" value="1">
                            <input type="hidden" class="text_cnt" value="{{$p}}">
                            @if(isset($current_logic[$p]))
                                @for($ii=0;$ii<count($current_logic[$p]);$ii++)
                                        <?php
                                            $target= -1;
                                            for ($n=0;$n<count($question_infos);$n++)
                                            {
                                                if($question_infos[$n]->id == $current_logic[$p][$ii][1])
                                                {
                                                    $target = $n;
                                                    break;
                                                }  
                                            }
                                            if ($target < 0)
                                                continue;
                                            $content= json_decode($question_infos[$target]->content);
                                        ?>                            
                                        <div class=" row clone_condition logic_condition_{{ $ii }}" style="padding-top:10px;">
                                            <div class="row col-12" style="padding-top:10px;">
                                                <div class="col-3">
                                                    <select class="form-control btn-primary first_operator" name="first_operator" placeholder="Options">
                                                        @if($current_logic[$p][$ii][0]==0)
                                                            <option value="0" selected>And</option>
                                                            <option value="1">Or</option>
                                                        @else
                                                            <option value="0">And</option>
                                                            <option value="1" selected>Or</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col-5">
                                                
                                                        <input type="text" class="qt_name btn-success form-control" value="{{ $question_infos[$target]->id }}.{{$question_infos[$target]->question }}">
                                                        <div class="tree_4 tree-demo" display="none">
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
                                                <input class="qt_type" type="hidden" value="{{$question_infos[$target]->questiontype}}">
                                                <div class="col-4">
                                                    <select class="form-control btn-warning operators" name="operators" placeholder="Options">
                                                        <?php
                                                        $operators=["equals","not equals","contains","not contains","greater","less","greater or equals","less or equals"];
                                                        ?>
                                                        @for($t=0;$t<count($operators);$t++)
                                                            @if($current_logic[$p][$ii][2] == $t)
                                                                <option value="{{ $t }}" selected>{{ $operators[$t]}}</option>
                                                            @else 
                                                                <option value="{{ $t }}">{{ $operators[$t] }}</option>
                                                            @endif
                                                        @endfor                                       
                                                    </select>
                                                </div>
                                                <div class="col-12 logic-content" style="padding-top:10px">

                                                    @if($question_infos[$target]->questiontype == 0)
                                                        <div class="row main-content" id="cond_{{$question_infos[$target]->id }}"  >                                                
                                                            <div class="col-12 form-group">
                                                                <div class="form-group form-md-line-input has-info">
                                                                    <textarea class="form-control" rows="1">{{ $current_logic[$p][$ii][3] }}</textarea>
                                                                    <label>Please enter/select the value </label>    
                                                                </div>                        
                                                            </div>                                                  
                                                        </div> 
                                                    @elseif($question_infos[$target]->questiontype == 1)
                                                        <div class="row  main-content" id="cond_{{$question_infos[$target]->id}}"  > 
                                                            <div class="col-12 form-group  logic_check" style="margin-left:20px;">
                                                                @for($num= 0; $num < count($content) - 2; $num++)
                                                                <?php
                                                                    $check_vals = json_decode($current_logic[$p][$ii][3]);
                                                                    //$check_id = intval($current_logic[$p][$ii][3] /pow(2,count($content)-$num-1));
                                                                    //$current_logic[$p][$ii][3]=$current_logic[$p][$ii][3] % pow(2,count($content)-$num-1);
                                                                ?>
                                                                    <div  class="checkbox">
                                                                        @if(isset($check_vals[$num]))
                                                                            @if ( $check_vals[$num] > 0)
                                                                                <label><input type="checkbox" class="checkbox_{{ $num }} check_box_q" value="{{$content[$num]->score}}" checked>{{ $content[$num]->label }}</label>
                                                                            @else
                                                                                <label><input type="checkbox"  class="checkbox_{{ $num }} check_box_q" value="{{$content[$num]->score}}">{{ $content[$num]->label }}</label>
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                @endfor    
                                                            </div>           
                                        
                                                        </div>
                                                    @elseif($question_infos[$target]->questiontype == 2)
                                                        <div class="row main-content" id="cond_{{$question_infos[$target]->id}}"  > 
                                                            <div class="col-12 form-group logic_radio" style="margin-left:20px;">
                                                                @for($num= 0; $num < count($content) - 2; $num++)
                                                                <?php
                                                                    $check_vals = json_decode($current_logic[$p][$ii][3]);
                                                                ?>
                                                                    <div  class="checkbox">
                                                                        @if ( $check_vals[$num] > 0)
                                                                            <label><input type="radio"  name="optradio{{ $question_infos[$target]->id }}_{{ $p }}"  class="radio_{{ $num }}"  checked value="{{$content[$num]->score}}">{{ $content[$num]->label}}</label>
                                                                        @else
                                                                            <label><input type="radio"  name="optradio{{ $question_infos[$target]->id }}_{{ $p }}"  class="radio_{{ $num }}" value="{{$content[$num]->score}}">{{ $content[$num]->label}}</label>
                                                                        @endif
                                                                    </div>
                                                                @endfor    
                                                            </div> 
                                                        </div>
                                                    @elseif($question_infos[$target]->questiontype == 6)
                                                        <div class="row main-content" id="cond_{{$question_infos[$target]->id}}"  > 
                                                            <div class="col-12 form-group logic_radio" style="margin-left:20px;">
                                                                @for($num= 0; $num < count($content) - 1; $num++)
                                                                <?php
                                                                    $check_vals = json_decode($current_logic[$p][$ii][3]);
                                                                ?>
                                                                    <div  class="checkbox">
                                                                        @if ( $check_vals[$num] > 0)
                                                                            <label><input type="radio"  name="optradio{{ $question_infos[$target]->id }}_{{ $p }}"  class="radio_{{ $num }}"  checked value="{{$content[$num]->score}}">{{ $content[$num]->label}}</label>
                                                                        @else
                                                                            <label><input type="radio"  name="optradio{{ $question_infos[$target]->id }}_{{ $p }}"  class="radio_{{ $num }}" value="{{$content[$num]->score}}">{{ $content[$num]->label}}</label>
                                                                        @endif
                                                                    </div>
                                                                @endfor    
                                                            </div> 
                                                        </div>
                                                    @elseif($question_infos[$target]->questiontype == 3)
                                                        <div class="row main-content logic_img"  id="cond_{{$question_infos[$target]->id}}"  > 
                                                            <?php
                                                                $images = $content[0]->image;
                                                                $scores = $content[0]->score;
                                                            ?>
                                                            @for($num= 0; $num < count($images); $num++)
                                                            <?php
                                                                $check_vals = json_decode($current_logic[$p][$ii][3]);
                                                                //$check_id =intval($current_logic[$p][$ii][3] /pow(2,count($content)-$num-1));
                                                                //$current_logic[$p][$ii][3]=$current_logic[$p][$ii][3] % pow(2,count($content)-$num-1);
                                                            ?>
                                                                <div class="col-md-3 col-sm-6 image_box" style="padding-left:20px;width:7vw;height:10vw;" display="inline-flex" >
                                                                    <div  class="checkbox">

                                                                        @if ( $check_vals[$num] > 0)
                                                                        <input type="checkbox" class="imagebox_{{ $num }}" checked value="{{$scores[$num]}}">
                                                                        @else
                                                                            <input type="checkbox"  class="imagebox_{{ $num }}" value="{{$scores[$num]}}">
                                                                        @endif
                                                                    </div>
                                                                    <img src="/uploads/image/{{ $images[$num] }}"  width="50px" height="50px" style="object-fit:fill">
                                                                </div>
                                                            @endfor
                                                        </div>
                                                    @elseif($question_infos[$target]->questiontype == 4)
                                                        <div class="row main-content" id="cond_{{$question_infos[$target]->id}}"  >
                                                            <div class="col-12 form-group logic_radio">
                                                            <?php
                                                                $input_vals = json_decode($current_logic[$p][$ii][3]);
                                                                $content = $question_infos[$target]->content;
                                                                $inputs = explode('type="text" value="', $content);
                                                                $table_html = "";
                                                                for($i = 0; $i < count($inputs); $i++){
                                                                    if($i == count($inputs) - 1)
                                                                        $table_html .= $inputs[$i];
                                                                    else{
                                                                        $table_html .= $inputs[$i].'type="text" value="'.$input_vals[$i];
                                                                    }
                                                                }
                                                                echo $table_html;
                                                            ?>
                                                            </div>
                                                        </div>
                                                    @elseif($question_infos[$target]->questiontype == 5 || $question_infos[$target]->questiontype == 8)
                                                        <div class="row main-content" id="cond_{{$question_infos[$target]->id}}"  >
                                                            <div class="col-12 form-group logic_radio" style="margin-left:20px;">
                                                                @for($num= 0; $num< count($content) - 3; $num++)
                                                                <?php
                                                                    $check_vals = json_decode($current_logic[$p][$ii][3]);
                                                                    //$check_id =intval($current_logic[$p][$ii][3] /pow(2,count($content)-$num-1));
                                                                    //$current_logic[$p][$ii][3]=$current_logic[$p][$ii][3] % pow(2,count($content)-$num-1);
                                                                ?>
                                                                    <div  class="checkbox">
                                                                        @if ( $check_vals[$num] > 0)
                                                                            <label><input type="radio"  name="optradio{{ $question_infos[$target]->id }}_{{ $p }}"  class="radio_{{ $num }}"  checked value="{{$content[$num]->score}}">{{ $content[$num]->label}}</label>
                                                                        @else
                                                                            <label><input type="radio"  name="optradio{{ $question_infos[$target]->id }}_{{ $p }}"  class="radio_{{ $num }}" value="{{$content[$num]->score}}">{{ $content[$num]->label}}</label>
                                                                        @endif
                                                                    </div>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="row main-content" id="cond_{{$question_infos[$target]->id}}"  > 
                                                            <div class="col-12 form-group">
                                                                <div class="form-group form-md-line-input has-info">
                                                                    <textarea class="form-control" rows="1">{{ $current_logic[$p][$ii][3] }}</textarea>
                                                                    <label>Please enter/select the value </label>    
                                                                </div>  
                                                            </div>                                                 
                                                        </div>

                                                    @endif

                                                </div>
                                                <div class="col-12" style="padding-top:10px;">                                            
                                                    <a class="btn btn-xs  btn-danger del-btnx" style="cursor:pointer;"><i class="fa fa-trash" style="color:white"></i></a>
                                                </div>
                                            </div>
                                        
                                        </div>                               
                                @endfor
                                @for($hh =count($current_logic[$p]);$hh<10;$hh++)
                                    <div class="row clone_condition logic_condition_{{ $hh }}" style="padding-top:10px;" >
                                            <div class="col-3">
                                                <select class="form-control btn-primary first_operator" name="first_operator" placeholder="Options">
                                                    <option value="0">And</option>
                                                    <option value="1">Or</option>
                                                </select>
                                            </div>
                                            <div class="col-4">                                            
                                                <input type="text" class="qt_name btn-success form-control" >
                        
                                                <div class="tree_4 tree-demo" display="none">
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
                            @endif
                             <div class="main-content" id="cond_0"></div>                              
                        </div>
                        <button class="btn btn-primary condition_add" style="margin-top:20px">Add Conditon</button>
                    </div>            
                        
                </div>  
                @endfor 

                @for ($p= count($current_content);$p<10;$p++)
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
                            <input type="hidden" class="text_cnt" value="{{$p}}">
                           
                            @for($hh =0;$hh<10;$hh++)
                                <div class="row clone_condition logic_condition_{{ $hh }}" style="padding-top:10px;" >
                                        <div class="col-3">
                                            <select class="form-control first_operator" name="first_operator" placeholder="Options">
                                                <option value="0">And</option>
                                                <option value="1">Or</option>
                                            </select>
                                        </div>
                                        <div class="col-4">                                            
                                            <input type="text" class="qt_name form-control" >
                                            <div class="tree_4 tree-demo" display="none">
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
                                            <select class="form-control operators" name="operators" placeholder="Options">
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
    <script type="text/javascript" src="{{asset('js/textgroup-edit.js')}}"></script>

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
            TextgroupEdit.init();  
            //UIToastr.init();
            $('.custom-hide').remove();
        });
    </script>

    


    
@stop

