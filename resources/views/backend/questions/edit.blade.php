@extends('backend.layouts.app')
@section('title', __('labels.backend.questions.title').' | '.app_name())

@section('content')
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">


    <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="https://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>

    {{-- Test Selection --}}
    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">Selection of Tests</h3>
            <div class="float-right">
                <a href="{{ route('admin.questions.index') }}"
                   class="btn btn-success">@lang('labels.backend.questions.view')</a>
            </div>         
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('tests', 'Test', ['class' => 'control-label']) !!}
                    @php
                        $i=0;
                        $selected_tests = array();
                        foreach($question_tests as $q){
                            array_push($selected_tests, $q->test_id);
                        }
                    @endphp
                     <select class="form-control select2 required" name="tests_id" id="tests_id" placeholder="Options" multiple>
                        @foreach($tests as $test)
                            <option value="{{$test->id}}" data-color1="{{$test->color1}}" data-color2="{{$test->color2}}"  @if(in_array($test->id, $selected_tests)) selected=true @endif>{{ $test->title}}</option>
                        @endforeach  
                    </select>
                    
                     <p class="help-block"></p>
                    @if($errors->has('question'))
                        <p class="help-block">
                            {{ $errors->first('question') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- End Test Selection --}}


        <div class="row">
            {{-- Question --}}
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h3 class="page-title float-left mb-0">Question Deatils</h3>           
                    </div>
                    <div id="question_edit" class="card-body">
                        <input type="hidden" id="question_id" value="{{$question->id}}">
                        <div class="row">
                            <div class="col-12" >
                                    <div class="form-group">
                                        <div class="form-group form-md-line-input has-info" style="margin-top:10px">
<!--                                            <textarea name="question_content" id="question_content" class="form-control ckeditor"></textarea>-->
                                            <!-- <input type="text" class="form-control"   id="question_content"> -->
                                            {!! Form::textarea('content', $question->question , ['class' => 'form-control ckeditor', 'placeholder' => '','name'=>'question_content','id' => 'question_content']) !!}
                                            <label for="question_content">Question</label>
                                        </div>      
                                        <div class="row">
                                            <div class="col-12 col-lg-6 form-group">
                                                {!! Form::label('f_color1',trans('labels.backend.tests.fields.color1'), ['class' => 'control-label']) !!}
                                                {!! Form::color('f_color1', '', ['class' => 'form-control ', 'name'=>'f_color1']) !!}
                                            </div>
                                        </div>               
                                        <div class="form-group form-md-line-input has-info" style="margin-top:10px">
<!--                                            <textarea name="help-editor" id="help-editor" class="form-control ckeditor"></textarea>-->
                                            {!! Form::textarea('content', $question->help_info , ['class' => 'form-control ckeditor', 'placeholder' => '','id' => 'help-editor']) !!}
                                            <label for="question_help_info">Question Help or Information</label>
                                        </div>       
                                        <div class="row">
                                            <div class="col-12 col-lg-6 form-group">
                                                <label for="">Help information hide/show</label>
                                            <label for="hint"> <input type='radio' name='hint' class='helpaccess' value='0' @if ($question->access_help_info == 0) checked @endif   /> Hide</label>
                                            <label for="hint"><input type='radio' name='hint' class='helpaccess' value='1' @if ($question->access_help_info == 1) checked @endif /> Show</label>
                                            </div>
                                        </div>      
                                        <div class="form-group form-md-line-input has-info">
                                            {!! Form::textarea('content', $question->hint_info , ['class' => 'form-control ckeditor', 'placeholder' => '','id' => 'hint-editor']) !!}
                                            <label for="question_hint_info">Question Hint</label>
                                        </div>    
                                        <div class="row">
                                            <div class="col-12 col-lg-6 form-group">
                                                <label for="">Hint information hide/show</label>
                                            <label for="hint"> <input type='radio' name='hintRight' class='hintaccess' value='0' @if ($question->access_hint_info == 0) checked @endif   /> Hide</label>
                                            <label for="hint"><input type='radio' name='hintRight' class='hintaccess' value='1' @if ($question->access_hint_info == 1) checked @endif /> Show</label>
                                            </div>
                                        </div>            
                                        <div class="row">
                                            <div class="col-12 col-lg-6 form-group">
                                                {!! Form::label('f_color2',trans('labels.backend.tests.fields.color2'), ['class' => 'control-label']) !!}
                                                {!! Form::color('f_color2', '', ['class' => 'form-control ', 'name'=>'f_color2']) !!}
                                            </div>
                                        </div>   
                                        @if($errors->has('question'))
                                            <p class="help-block">
                                                {{ $errors->first('question') }}
                                            </p>
                                        @endif
                                    </div>    
                                    <div class="mt-2">
                                        <img id="preview" src="@if($question->questionimage!="" && $question->questionimage!=null) {{asset('uploads/image/'.$question->questionimage)}} @endif" width="100%">
                                        <form id="question_type_image" action="" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label class="form-label">Image</label>
                                                <input type="file" id="img" class="form-control" name="file[]" accept="image/*">
                                                <input type="hidden" id="quiz_img" name="quiz_img" value="{{$question->questionimage}}">
                                            </div>
                                        </form>
                                    </div>       
                            </div>
                        </div>
                    </div>     
                </div>
                {{-- Question Type --}}
                <div class="card">
                    <div class="card-header">
                        <h3>Question Type</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            @php
                                $question_type =['Single Input','Check Box','RadioGroup','Image','Matrix','Rating','Dropdown','File','Stars','Range','€'];
                            @endphp
                            {!! Form::label('question_type', trans('labels.backend.questions.fields.question_type'), ['class' => 'control-label']) !!}
                            <select class="form-control"  name="options" id="question_type" placeholder="Options">
                                @for($i=0 ;$i< count($question_type);$i++)   
                                    <option value="{{$i}}" @if($question->questiontype==$i) selected @endif>{{ $question_type[$i]}}</option>
                                @endfor
                            </select>
                            <p class="help-block"></p>
                        </div>
                        <div id="question-type-box">
                            
                            @switch($question->questiontype)
                                {{-- Single Input --}}
                                @case(0)
                                
                                    @include('backend.questions.components.simple.single_input', [
                                        'content' => $question->content
                                    ])
                                    @include('backend.questions.components.simple.checkbox',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.radiogroup',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.image',['display' => 'none'])  
                                    @include('backend.questions.components.simple.matrix',['display' => 'none'])
                                    @include('backend.questions.components.simple.file',['display' => 'none'])
                                    @include('backend.questions.components.simple.dropdown',['display' => 'none'])
                                    @include('backend.questions.components.simple.range',['display' => 'none'])
                                    @include('backend.questions.components.simple.rating',['display' => 'none'])
                                    @include('backend.questions.components.simple.euro',['display' => 'none'])
                                    @break
                                {{-- Checkbox --}}
                                @case(1)
                                    @include('backend.questions.components.simple.checkbox',[
                                        'content' => $question->content
                                    ])
                                    @include('backend.questions.components.simple.single_input',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.radiogroup',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.image',['display' => 'none'])  
                                    @include('backend.questions.components.simple.matrix',['display' => 'none'])
                                    @include('backend.questions.components.simple.file',['display' => 'none'])
                                    @include('backend.questions.components.simple.dropdown',['display' => 'none'])
                                    @include('backend.questions.components.simple.range',['display' => 'none'])
                                    @include('backend.questions.components.simple.rating',['display' => 'none'])
                                    @include('backend.questions.components.simple.euro',['display' => 'none'])
                                    @break
                                {{-- RadioGroup --}}
                                @case(2)
                                    @include('backend.questions.components.simple.radiogroup',[
                                        'content' => $question->content
                                    ])
                                    @include('backend.questions.components.simple.checkbox',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.single_input',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.image',['display' => 'none'])  
                                    @include('backend.questions.components.simple.matrix',['display' => 'none'])
                                    @include('backend.questions.components.simple.file',['display' => 'none'])
                                    @include('backend.questions.components.simple.dropdown',['display' => 'none'])
                                    @include('backend.questions.components.simple.range',['display' => 'none'])
                                    @include('backend.questions.components.simple.rating',['display' => 'none'])
                                    @include('backend.questions.components.simple.euro',['display' => 'none'])
                                    @break
                                {{-- Image --}}
                                @case(3)
                                    @include('backend.questions.components.simple.image')
                                    @include('backend.questions.components.simple.radiogroup',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.checkbox',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.single_input',[ 'display' => 'none'])  
                                    @include('backend.questions.components.simple.matrix',['display' => 'none'])
                                    @include('backend.questions.components.simple.file',['display' => 'none'])
                                    @include('backend.questions.components.simple.dropdown',['display' => 'none'])
                                    @include('backend.questions.components.simple.range',['display' => 'none'])
                                    @include('backend.questions.components.simple.rating',['display' => 'none'])
                                    @include('backend.questions.components.simple.euro',['display' => 'none'])
                                    @break
                                {{-- Matrix --}}
                                @case(4)
                                    @include('backend.questions.components.simple.matrix',[
                                        'content' => $question->content
                                    ])
                                    @include('backend.questions.components.simple.radiogroup',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.checkbox',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.single_input',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.image',['display' => 'none'])  
                                    @include('backend.questions.components.simple.file',['display' => 'none'])
                                    @include('backend.questions.components.simple.dropdown',['display' => 'none'])
                                    @include('backend.questions.components.simple.range',['display' => 'none'])
                                    @include('backend.questions.components.simple.rating',['display' => 'none'])
                                    @include('backend.questions.components.simple.euro',['display' => 'none'])
                                    @break
                                {{-- Rating --}}
                                @case(5)
                                {{-- Stars --}}
                                @case(8)
                                    @include('backend.questions.components.simple.rating',[
                                        'content' => $question->content,
                                        'default_color' => $question->color1 ? $question->color1 : $current_tests[0]->color1
                                    ])
                                    @include('backend.questions.components.simple.radiogroup',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.checkbox',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.single_input',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.image',['display' => 'none'])  
                                    @include('backend.questions.components.simple.matrix',['display' => 'none'])
                                    @include('backend.questions.components.simple.file',['display' => 'none'])
                                    @include('backend.questions.components.simple.dropdown',['display' => 'none'])
                                    @include('backend.questions.components.simple.range',['display' => 'none'])
                                    @include('backend.questions.components.simple.euro',['display' => 'none'])
                                    @break
                                {{-- Dropdown --}}
                                @case(6)
                                    @include('backend.questions.components.simple.dropdown',[
                                        'content' => $question->content
                                    ])
                                    @include('backend.questions.components.simple.radiogroup',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.checkbox',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.single_input',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.image',['display' => 'none'])  
                                    @include('backend.questions.components.simple.matrix',['display' => 'none'])
                                    @include('backend.questions.components.simple.file',['display' => 'none'])
                                    @include('backend.questions.components.simple.range',['display' => 'none'])
                                    @include('backend.questions.components.simple.rating',['display' => 'none'])
                                    @include('backend.questions.components.simple.euro',['display' => 'none'])
                                    @break
                                {{-- File --}}
                                @case(7)
                                    @include('backend.questions.components.simple.file')
                                    @include('backend.questions.components.simple.radiogroup',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.checkbox',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.single_input',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.image',['display' => 'none'])  
                                    @include('backend.questions.components.simple.matrix',['display' => 'none'])
                                    @include('backend.questions.components.simple.dropdown',['display' => 'none'])
                                    @include('backend.questions.components.simple.range',['display' => 'none'])
                                    @include('backend.questions.components.simple.rating',['display' => 'none'])
                                    @include('backend.questions.components.simple.euro',['display' => 'none'])
                                    @break
                                {{-- Range --}}
                                @case(9)
                                    
                                    @include('backend.questions.components.simple.range',[
                                        'content' => $question->content
                                    ])
                                    @include('backend.questions.components.simple.radiogroup',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.checkbox',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.single_input',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.matrix',['display' => 'none'])
                                    @include('backend.questions.components.simple.file',['display' => 'none'])
                                    @include('backend.questions.components.simple.rating',['display' => 'none'])
                                    @include('backend.questions.components.simple.euro',['display' => 'none'])
                                    @break
                                {{-- Euro --}}
                                @case(10)
                                    @include('backend.questions.components.simple.euro',[
                                        'content' => $question->content
                                    ])
                                    @include('backend.questions.components.simple.radiogroup',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.checkbox',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.single_input',[ 'display' => 'none'])
                                    @include('backend.questions.components.simple.image',['display' => 'none'])  
                                    @include('backend.questions.components.simple.matrix',['display' => 'none'])
                                    @include('backend.questions.components.simple.file',['display' => 'none'])
                                    @include('backend.questions.components.simple.dropdown',['display' => 'none'])
                                    @include('backend.questions.components.simple.range',['display' => 'none'])
                                    @include('backend.questions.components.simple.rating',['display' => 'none'])
                                    @break
                                @default
                                    
                            @endswitch

                            
                            <div id="score-box" class="form-group" style="display: none;">
                                <label class="from-label">Score</label>
                                <input type="number" id="score" name="score"  class="form-control" placeholder="0" @if($question->questiontype==0) value="{{$question->score}}" @endif>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End Question Type --}}
                
                {{-- Logic --}}
                <div class="card">
                    <div class="card-header">
                        <h3 class="page-title float-left mb-0">Logic</h3>          
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 form-group">                    
                                <div>
                                    <div class="logic_part" style="border:1px solid #bbbbbb;padding:10px;">
                                        {{--  <a id="logic_open" class="btn btn-primary" style="color:white; margin-top:10px;">Logic Start</a>  --}}
                                    {{--  <a id="condition_add" class="btn btn-success" style="color:white; margin-top:10px;" >Add Condition</a>  --}}
                                        <div class="text-right">
                                            <button id="condition_add" class="btn btn-danger">Add Condition</button>
                                        </div>
                                        <div id="sortable-14">
                                            @if($question->logic != "[]")
                                                @php
                                                    $logics = json_decode($question->logic); 
                                                @endphp
                                                @foreach($logics as $key => $logic)
                                                    <div class="logic_condition row" id="logic_condition_{{$key}}" style="padding-top:10px;">
                                                            <div class="col-3">
                                                                <select class="form-control btn-primary first_operator" name="first_operator" placeholder="Options">
                                                                    <option value="0" {{ ($logic[0] == 0)?'selected':'' }}>And</option>
                                                                    <option value="1" {{ ($logic[0] == 1)?'selected':'' }}>Or</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-4">
                                                                @php 
                                                                    $data= DB::table('questions')->where('id','=',$logic[1])->first();
                                                                @endphp
                                                                @if(isset($data->question))
                                                                    <input type="text" class="btn-success qt_name form-control" id="logic_qt_name" value="{{$logic[1].'.'.$data->question}}">
                                                                @else
                                                                    <input type="text" class="btn-success qt_name form-control" id="logic_qt_name" value="">
                                                                @endif
                                                                <div class="tree_1 tree-demo" display="none">
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
                                                            @if(isset($data->id))
                                                                <input class="qt_type" type="hidden" value="{{$data->id}}">
                                                            @else
                                                                <input class="qt_type" type="hidden" value="">
                                                            @endif
                                                            <div class="col-5">                                    
                                                                <select class="form-control btn-warning operators" name="operators" placeholder="Options">
                                                                    <?php
                                                                        $operators=["equals","not equals","contains","not contains","greater","less","greater or equals","less or equals"];
                                                                    ?>
                                                                    @for($i=0;$i<count($operators);$i++)
                                                                        <option value="{{ $i }}" {{($logic[2] == $i)?'selected':''}}>{{ $operators[$i] }}</option>
                                                                    @endfor                                       
                                                                </select>
                                                            </div>
                                                            <div class="col-12 logic-content" style="padding-top:10px">
                                                            </div>
                                                            <div class="col-12" style="padding-top:10px;">                                            
                                                                <a class="btn btn-xs  btn-danger del-btnx" style="cursor:pointer;"><i class="fa fa-trash" style="color:white"></i></a>
                                                            </div>
                                                            @if(isset($logic[3]))
                                                                @foreach($logic[3] as $k => $val)
                                                                    <input type="hidden" name="logic_{{$logic[1]}}[]" value="{{$val}}">
                                                                @endforeach
                                                            @endif                         
                                                    </div>
                                                @endforeach
                                                @for($q = 0; $q < 5; $q++)
                                                    <div class="logic_condition row clone" id="logic_condition_{{count($logics) + $q}}" style="padding-top:10px;">
                                                        <div class="col-3">
                                                            <select class="form-control btn-primary first_operator" name="first_operator" placeholder="Options">
                                                                <option value="0">And</option>
                                                                <option value="1">Or</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-4">
                                                        
                                                            <input type="text" class="btn-success qt_name form-control" >
                                    
                                                            <div class="tree_1 tree-demo" display="none">
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
                                                        </div>                                    
                                                
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    </div>
                                                @endfor
                                            @else
                                                @for($i = 0; $i < 5; $i++)
                                                    <div class="logic_condition row" id="{{'logic_condition_'.$i}}" style="padding-top:10px;">
                                                        <div class="col-3">
                                                            <select class="form-control btn-primary first_operator" name="first_operator" placeholder="Options">
                                                                <option value="0">And</option>
                                                                <option value="1">Or</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-4">
                                                        
                                                            <input type="text" class="btn-success qt_name form-control" >
                                    
                                                            <div class="tree_1 tree-demo" display="none">
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
                                                        </div>                                    
                                                
                                                    </div>
                                                @endfor
                                            @endif
                                        </div>
                                        {{-- <div class="logic_condition row condition-sample" id="logic_condition" style="padding-top:10px;">
                                            <div class="col-3">
                                                <select class="form-control btn-primary first_operator" name="first_operator" placeholder="Options">
                                                    <option value="0">And</option>
                                                    <option value="1">Or</option>
                                                </select>
                                            </div>
                                            <div class="col-4">
                                            
                                                <input type="text" class="btn-success qt_name form-control" >
                        
                                                <div class="tree_1 tree-demo" display="none">
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
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                                </div>
                                @if($errors->has('question'))
                                    <p class="help-block">
                                        {{ $errors->first('question') }}
                                    </p>
                                @endif
                        </div>
                
                    </div>
                </div>
                {{-- End Logic --}}
            </div>
            {{-- End Question --}}

            {{-- Question Properties --}}
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3>Layout Properties</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-check">
                                    <input type="checkbox" name="required" id="required" placeholder="" class="form-check-input" value="1" @if($question->required==1) checked @endif/>
                                    {!! Form::label('required', 'Is Required', ['class' => 'form-check-label']) !!}
                                </div>
                                <div id="more_than_one_answer_box" class="form-check">
                                    <input type="checkbox" name="more_than_one_answer" id="more_than_one_answer" placeholder="" class="form-check-input" value="1" @if($question->more_than_one_answer==1) checked @endif />
                                    {!! Form::label('more_than_one_answer', 'More than 1 answers', ['class' => 'form-check-label']) !!}
                                </div>
                                {!! Form::label('state', 'State', ['class' => 'control-label']) !!}
                                <select class="form-control" name="options" id="state" placeholder="Options">
                                    @php
                                        $states = [
                                            'deafult' => 'Default',
                                            'collapased' => 'Collapsed',
                                            'expanded' => 'Expanded'
                                        ];
                                    @endphp
                                    @foreach($states as $key=>$value)
                                        <option value="{{$key}}" @if($question->state==$key) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>
                                {!! Form::label('title_location', 'Title location', ['class' => 'control-label']) !!}
                                <select class="form-control" name="options" id="title_location" placeholder="Options">
                                    @php
                                        $title_location = [
                                            'col-12' => 'Default',
                                            'col-12 order-1' => 'Top',
                                            'col-12 order-2' => 'Center',
                                            'col-12 order-3' => 'Bottom',
                                            'col-6 order-1' => 'Left',
                                            'col-6 order-2' => 'Right',
                                            'd-none' => 'Hide'
                                        ];
                                    @endphp
                                    @foreach($title_location as $key=>$value)
                                        <option value="{{$key}}" @if($question->titlelocation==$key) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>
                                {!! Form::label('answer_location', 'Answer location', ['class' => 'control-label']) !!}
                                <select class="form-control" name="options" id="answerposition" placeholder="Options">
                                    @php
                                        $answer_location = [
                                            'col-12' => 'Default',
                                            'col-12 order-1' => 'Top',
                                            'col-12 order-3' => 'Bottom',
                                            'col-12 order-2' => 'Center',
                                            'col-8 order-1' => 'Left',
                                            'col-8 order-2' => 'Right',
                                            'd-none' => 'Hide'
                                        ];
                                    @endphp
                                    @foreach($answer_location as $key=>$value)
                                        <option value="{{$key}}" @if($question->answerposition==$key) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>
                                {!! Form::label('image_location', 'Image location', ['class' => 'control-label']) !!}
                                <select class="form-control" name="options" id="imageposition" placeholder="Options">
                                    @php
                                        $image_location = [
                                            'col-12' => 'Default',
                                            'col-12 order-1' => 'Top',
                                            'col-12 order-3' => 'Bottom',
                                            'col-12 order-2' => 'Center',
                                            'col-4 order-1' => 'Left',
                                            'col-4 order-2' => 'Right',
                                            'd-none' => 'Hide'
                                        ];
                                    @endphp
                                    @foreach($image_location as $key=>$value)
                                        <option value="{{$key}}" @if($question->imageposition==$key) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>
                                {!! Form::label('image_aligment', 'Image Aligment', ['class' => 'control-label']) !!}
                                <select class="form-control" name="options" id="image_aligment" placeholder="Options">
                                    @php
                                        $image_aligment = [
                                            'col-12' => 'Full',
                                            'offset-md-6 col-6' => 'Right',
                                            'offset-md-0 col-6' => 'Left',
                                            'offset-md-3 col-6' => 'Center',
                                        ];
                                    @endphp
                                    @foreach($image_aligment as $key=>$value)
                                        <option value="{{$key}}" @if($question->image_aligment==$key) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>
                                {!! Form::label('answer_aligment', 'Answer Aligment', ['class' => 'control-label']) !!}
                                <select class="form-control" name="options" id="answer_aligment" placeholder="Options">
                                    @php
                                        $answer_aligment = [
                                            'offset-md-0' => 'Full',
                                            '' => 'Left',
                                            'offset-md-6' => 'Right',
                                            'offset-md-3' => 'Center',
                                        ];
                                    @endphp
                                    @foreach($answer_aligment as $key=>$value)
                                        <option value="{{$key}}" @if($question->answer_aligment==$key) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>
                                {!! Form::label('question_bg_color', 'Question Background', ['class' => 'control-label']) !!}
                                <select class="form-control" name="options" id="question_bg_color" placeholder="Options">
                                    @php
                                        $question_bg_color = [
                                            '#fff' => 'White',
                                            '#ff5733' => 'Light Brown',
                                            '#ffe933' => 'Yellow',
                                            '#cab81d' => 'Dark yellow',
                                            '#1d76ca' => 'Blue',
                                        ];
                                    @endphp
                                    @foreach($question_bg_color as $key=>$value)
                                        <option value="{{$key}}" @if($question->question_bg_color==$key) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>
                                <!-- {!! Form::label('help_info_location', 'Help Info location', ['class' => 'control-label']) !!}
                                <select class="form-control" name="options" id="help_info_location" placeholder="Options">
                                    @php
                                        $help_info_location = [
                                            'deafult' => 'Default',
                                            'top' => 'Top',
                                            'bottom' => 'Bottom',
                                            'left' => 'Left',
                                            'hidden' => 'Hidden'
                                        ];
                                    @endphp
                                    @foreach($help_info_location as $key=>$value)
                                        <option value="{{$key}}" @if($question->help_info_location==$key) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select> -->
                                {!! Form::label('indent', 'Indent', ['class' => 'control-label']) !!}
                                <input type="number" name="indent" id="indent" placeholder="" class="form-control" value="{{$question->indent}}"/>

                                {!! Form::label('width', 'Width', ['class' => 'control-label']) !!}
                                <input type="number" name="width" id="width" placeholder="" class="form-control" value="{{$question->width}}"/>

                                {!! Form::label('min_width', 'Min Width', ['class' => 'control-label']) !!}
                                <input type="number" name="min_width" id="min_width" placeholder="" class="form-control" value="{{$question->min_width}}"/>

                                {!! Form::label('max_width', 'Max Width', ['class' => 'control-label']) !!}
                                <input type="number" name="max_width" id="max_width" placeholder="" class="form-control" value="{{$question->max_width}}"/>

                                {!! Form::label('size', 'Size', ['class' => 'control-label']) !!}
                                <input type="number" name="size" id="size" placeholder="" class="form-control"  value="{{$question->size}}"/>

                                {{--{!! Form::label('font_size', 'Font size', ['class' => 'control-label']) !!}
                                <input type="text" name="font_size" id="font_size" placeholder="" class="form-control"  value="{{ $current_question->fontsize }}"/>
                                <div id="font_size1"></div>
                                {!! Form::label('column_count', 'Column Count', ['class' => 'control-label']) !!}
                                <input type="text" name="column_count" id="column_count" placeholder="" class="form-control" /> --}}

                                {!! Form::label('imagefit', 'Image Fit', ['class' => 'control-label']) !!}  
                                <select class="form-control" name="options" id="image_fit" placeholder="Options">
                                    @php
                                        $image_fit = [
                                            '0' => 'None',
                                            '1' => 'Contain',
                                            '2' => 'Cover',
                                            '3' => 'Fill'
                                        ];
                                    @endphp
                                    @foreach($image_fit as $key=>$value)
                                        <option value="{{$key}}" @if($question->imagefit==$key) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>
                                <div id="image_fit1"></div>
                                {!! Form::label('image_width', 'Image Width', ['class' => 'control-label']) !!}
                                <input type="text" name="image_width" id="image_width" placeholder="" class="form-control"  value="{{$question->imagewidth}}"/>
                                <div id="image_width1"></div>
                                {!! Form::label('image_height', 'Image Height', ['class' => 'control-label']) !!}
                                <input type="text" name="image_height" id="image_height" placeholder="" class="form-control"  value="{{$question->imageheight}}"/>
                                <div id="image_height1"></div>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="mt-2 mb-2">
                    <button id="save_data" class="btn btn-danger">Save Data</button>
                </div>
            </div>
            {{-- End Question Properties --}}
        </div>


    

    <!-- @for ($question=1; $question<=2; $question++)
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('option_text_' . $question, trans('labels.backend.questions.fields.option_text').'*', ['class' => 'control-label']) !!}
                    {!! Form::textarea('option_text_' . $question, old('option_text'), ['class' => 'form-control ', 'rows' => 3, 'required' =>  true]) !!}
                    <p class="help-block"></p>
                    @if($errors->has('option_text_' . $question))
                        <p class="help-block">
                            {{ $errors->first('option_text_' . $question) }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('explanation_' . $question, trans('labels.backend.questions.fields.option_explanation'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('explanation_' . $question, old('explanation_'.$question), ['class' => 'form-control ', 'rows' => 3]) !!}
                    <p class="help-block"></p>
                    @if($errors->has('explanation_' . $question))
                        <p class="help-block">
                            {{ $errors->first('explanation_' . $question) }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('correct_' . $question, trans('labels.backend.questions.fields.correct'), ['class' => 'control-label']) !!}
                    {!! Form::hidden('correct_' . $question, 0) !!}
                    {!! Form::checkbox('correct_' . $question, 1, false, []) !!}
                    <p class="help-block"></p>
                    @if($errors->has('correct_' . $question))
                        <p class="help-block">
                            {{ $errors->first('correct_' . $question) }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endfor
    <div class="col-12 text-center">
        {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn btn-danger mb-4 form-group']) !!}
    </div>

    {!! Form::close() !!} -->
    
    <script type="text/javascript" src="{{asset('js/select2.full.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/main.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script type="text/javascript" src="{{asset('js/ui-nestable.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.nestable.js')}}"></script>

    <!-- <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script> -->
    <script type="text/javascript" src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/dataTables.bootstrap.js')}}"></script>
    
    <script type="text/javascript" src="{{asset('js/table-editable.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/question-create.js')}}"></script>

    <script src="{{ asset('assets/metronic_assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>


    <script type="text/javascript" src="{{asset('js/3.5.1/jquery.min.js')}}"></script>

    {{-- <link href="{{asset('css/custom.css')}}"  rel="stylesheet" type="text/css"/> --}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets/metronic_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}"/>   
    <script type="text/javascript" src="{{asset('assets/metronic_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}"></script>

    
    <script src="{{asset('plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
<!--
    <script type="text/javascript" src="{{asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
    <script type="text/javascript" src="{{asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js')}}"></script>
    -->
    <script src="{{asset('/vendor/laravel-filemanager/js/lfm.js')}}"></script>
    <script>
        function radioScore(ele){
            alert("Score Updated");
            $(ele).data('value',ele.value);
            $('#'+ele.dataset.q_id).attr('value',ele.value);
            // console.log($('body .q_id'+ele.dataset.q_id).val());
            console.log($('#'+ele.dataset.q_id));

        }
 
        
        CKEDITOR.replace('question_content', {
            fontSize_defaultLabel : '34px',
            height : 300,
            filebrowserUploadUrl: `{{route('admin.questions.editor_fileupload',['_token' => csrf_token() ])}}`,
            filebrowserUploadMethod: 'form',
            extraPlugins: 'font,widget,colorbutton,colordialog,justify',
        });

        CKEDITOR.replace('help-editor', {
            height : 300,
            filebrowserUploadUrl: `{{route('admin.questions.editor_fileupload',['_token' => csrf_token() ])}}`,
            filebrowserUploadMethod: 'form',
            extraPlugins: 'font,widget,colorbutton,colordialog,justify',
        });

        CKEDITOR.replace('hint-editor', {
            height : 300,
            filebrowserUploadUrl: `{{route('admin.questions.editor_fileupload',['_token' => csrf_token() ])}}`,
            filebrowserUploadMethod: 'form',
            extraPlugins: 'font,widget,colorbutton,colordialog,justify',
        });

       
        /*$('.editor').each(function () {

            CKEDITOR.replace($(this).attr('id'), {
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}',

                //extraPlugins: 'font,smiley,lineutils,widget,codesnippet,prism,flash,colorbutton,colordialog',
                extraPlugins: 'font,widget,colorbutton,colordialog,justify',
            });

        });*/

        jQuery(document).ready(function(e) {       
            // initiate layout and plugins
            // Metronic.init(); // init metronic core components
            // Layout.init(); // init current layout
            // QuickSidebar.init(); // init quick sidebar
            // Demo.init(); // init demo features
            UITree.init();  
            UINestable.init();
            TableEditable.init();
            QuestionCreate.init();  
            //UIToastr.init();  
            $('#tests_id').on('change', function() {
                var selectedVals = $('#tests_id').val();
                if (selectedVals.length) {
                    var selectedOption = $(`#tests_id option[value=${selectedVals[0]}]`);
                    var color1 = selectedOption.data('color1');
                    var color2 = selectedOption.data('color2');
                    $('#color1').val(color1);
                    $('#color2').val(color2);
                    $('#color').val(color1);
                }
            })
        });
    </script>








    
@stop

