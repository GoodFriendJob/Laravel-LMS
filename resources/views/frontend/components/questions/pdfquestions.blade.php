<div class="question-ans">
<style>
  /* Center the loading spinner */
  #loader {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Add a semi-transparent background to overlay the page */
    z-index: 9999;
  }

  /* Style the spinning icon */
  #loader i {
    font-size: 50px;
    color: white;
  }

  /* Style the message text */
  #loader p {
    color: white;
    text-align: center;
    font-size: 18px;
    margin-top: 10px;
  }
</style>
@php
    $q_number=1;
    $ids = [];
    $identy = [];
    
    if($lesson->color1==NULL)
        $lesson->color1="#ffd1d1";
    if($lesson->color2==NULL)
        $lesson->color2="#badcee";
    if($lesson->text1==NULL)
        $fontstyle1="font-size:16px;font-family:Arial;color:black";
    if($lesson->text2==NULL)
        $fontstyle2="font-size:16px;font-family:Arial;color:black";
    
    
@endphp
@foreach ($lesson->questions as $key => $question)
    @php
        if($question->logic != "[]"){
            $logic_data = $question->logic;
            $decoded_json_data = json_decode($logic_data);
            foreach($decoded_json_data as $key=>$data){
                $ids[$question->id]=$data[1];
                $identy[$question->id] = $data[3];
            }
        }
    @endphp
@endforeach
@foreach ($lesson->questions as $question)
    @php
        $content = json_decode($question->content);
        if($question->questionimage==""){
            $question->questionimage=null;
        }
        $temp = explode('style="',$lesson->text1);
        echo $lesson->text1;
        $text1="color:#CCC;";
        foreach($temp as $index)
            if(strrpos($index,'"')>0)
                $text1=$text1.substr($index,0,strrpos($index,'"')).';';
        
        if(strpos($question->question,"strong") == true)
            $text1=$text1."font-weight:bold;";
        if(strpos($question->question,"em") == true)
            $text1=$text1."font-style:italic;";
        $temp = explode('style="',$lesson->text2);
        $text2="color:black;";
        foreach($temp as $index)
            if(strrpos($index,'"')>0)
                $text2=$text2.substr($index,0,strrpos($index,'"')).';';
        if(strpos($question->question,"strong") == true)
            $text2=$text2."font-weight:bold;";
        if(strpos($question->question,"em") == true)
            $text2=$text2."font-style:italic;";

        $temp = explode('style="',$question->question);
        $fontstyle1="color:black;";
        foreach($temp as $index)
            if(strrpos($index,'"')>0)
                $fontstyle1=$fontstyle1.substr($index,0,strrpos($index,'"')).';';
        if(strpos($question->question,"strong") == true)
            $fontstyle1=$fontstyle1."font-weight:bold;";
        if(strpos($question->question,"em") == true)
            $fontstyle1=$fontstyle1."font-style:italic;";
        
        $temp = explode('style="',$question->help_info);
        $fontstyle2="color:black;";
        foreach($temp as $index)
            if(strrpos($index,'"')>0)
                $fontstyle2=$fontstyle2.substr($index,0,strrpos($index,'"')).';';
        if(strpos($question->help_info,"strong") == true)
            $fontstyle2=$fontstyle2."font-weight:bold;";
        if(strpos($question->help_info,"em") == true)
            $fontstyle2=$fontstyle2."font-style:italic;";

        
    @endphp
    <script>
            $("body").append(`<style>#q_<?php echo $question->id?> .col-8.p-0{<?php echo $fontstyle1?>}</style>`)
    </script>
    @if(in_array($question->id,$ids))
        <div id="q_{{$question->id}}" class="question-card card custom-card mb-3" data-page="{{$question->page_number}}" style="background-color:{{($question->question_bg_color != '')?$question->question_bg_color:'#fff'}};box-shadow: 1px 1px 6px {{($question->question_bg_color != '' && $question->question_bg_color != '#fff')?'2px':'-3px'}}  {{($question->question_bg_color != '' && $question->question_bg_color != '#fff')?$question->question_bg_color:'#fff'}};">
            <form id="checkForm">
            <div class="row">
                    <div class="col-2 p-0"><span class="q_number gradient-bg my-auto p-2" style="background:{{$lesson->color1}};{{$text1}}">{{$q_number++}}</span></div>
                    <div class="col-8 p-0">
                        @if($question->titlelocation == 'col-12 order-1')
                        {!! html_entity_decode($question->question) !!}
                        <!-- <h2 class="d-inline-flex question-heading  w-100">
                            <span class="">{!! html_entity_decode($question->question) !!}</span>
                        <h2> -->
                        @endif
                    </div>
                    @if(!$question->required)
                        @php
                            $col = 4;
                        @endphp
                    @else
                        @php
                            $col = 2;
                        @endphp
                    @endif
                    @php 
                            if(isset($question->answer_aligment)){
                                if(($question->answer_aligment == 'offset-md-0')){
                                    $aligment = 'col-12 '.$question->answer_aligment;
                                }else{
                                    $aligment = $question->answer_aligment;
                                }
                            }else{
                                $aligment = 'col-12';
                            }  
                            if(isset($question->image_aligment)){
                                if(($question->image_aligment == 'offset-md-0')){
                                    $imagealigment = 'col-12 '.$question->image_aligment;
                                }else{
                                    $imagealigment = $question->image_aligment;
                                }
                            }else{
                                $imagealigment = 'col-12';
                            }
                            
                        @endphp
                    <div class="col-2 p-0 text-right ">
                        @if($question->help_info != "")
                            <span data-toggle="modal" data-target="#exampleModalLong{{$question->id}}" style="" class="d-inline-block mr-2"><i style="color:black" class="fas fa-question-circle"></i></span>
                        @endif
                        @include('frontend.components.questions.required')
                    </div>
                </div>
                <hr>
            <div class="card-body">
                @if($question->titlelocation == 'col-12' && $question->answerposition == 'col-12' && $question->imageposition == 'col-12')

                    <!-- question,answer,image in same row but first question,second image and third is answer -->
                    <div class="row">
                        <div class="{{$question->titlelocation}}">
                            <h2 class="">
                                <span class="">{!! $question->question !!}</span>
                            </h2>
                            <hr />
                        </div>
                        @if($question->questionimage!==null)
                        <div class="{{$question->imageposition}}">
                            <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                        </div>
                        @endif
                        <div class="{{$aligment}}">
                            @include('frontend.components.questions.inputs')
                        </div>
                    </div>
                
                @elseif($question->titlelocation == 'col-12 order-2' && $question->answerposition == 'col-8 order-2' && $question->imageposition == 'col-4 order-1')
                    <!-- question,answer,image in same row but first image,second question and third is answer -->      
                    <div class="row">
                        @if($question->questionimage!==null)
                        <div class="col-4">
                            <div class="{{$imagealigment}}">
                                <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                            </div>
                        </div>
                        @endif
                        <div class="col-4">
                            <div class="col-12">
                                {!! $question->question !!}
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="{{$aligment}}">
                                @include('frontend.components.questions.inputs')
                            </div>
                        </div>
                    </div>
                @elseif($question->titlelocation == 'col-6 order-1' && $question->answerposition == 'col-8 order-2' && $question->imageposition == 'col-12 order-2')
                    <!-- question,answer,image in same row but first question,second image and third is answer -->
                    <div class="row">
                        <div class="col-4">
                            <div class="col-12">
                                {!! $question->question !!}
                            </div>
                        </div>
                        @if($question->questionimage!==null)
                        <div class="col-4">
                            <div class="col-12">
                                <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                            </div>
                        </div>
                        @endif
                        <div class="col-4">
                            <div class="col-12">
                                @include('frontend. components.questions.inputs')
                            </div>
                        </div>
                    </div>
                @elseif($question->titlelocation == 'col-6 order-2' && $question->answerposition == 'col-12 order-2' && $question->imageposition == 'col-4 order-1')
                    <!-- question,answer,image in same row but first question,second answer and third is image -->
                    <div class="row">
                        <div class="col-4">
                            <div class="col-12">
                                {!! $question->question !!}
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="col-12">
                                @include('frontend.components.questions.inputs')
                            </div>
                        </div>
                        @if($question->questionimage!==null)
                            <div class="col-4">
                                <div class="col-12">
                                    <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                </div>
                            </div>
                        @endif
                    </div>
                @elseif($question->titlelocation == 'col-6 order-1' && $question->answerposition == 'col-12 order-2' && $question->imageposition == 'col-4 order-2')
                    <!-- question,answer,image in same row but first image,second answer and third is question -->
                    <div class="row">
                        @if($question->questionimage!==null)
                            <div class="col-4">
                                <div class="col-12">
                                    <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                </div>
                            </div>
                        @endif
                        
                        <div class="col-4">
                            <div class="col-12">
                                @include('frontend.components.questions.inputs')
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="col-12">
                                {!! $question->question !!}
                            </div>
                        </div>
                    </div>
                @elseif($question->titlelocation == 'col-12 order-2' && $question->answerposition == 'col-8 order-1' && $question->imageposition == 'col-4 order-1')
                    <!-- question,answer,image in same row but first answer,second question and third is image -->
                    <div class="row">
                        <div class="col-4">
                            <div class="col-12">
                                @include('frontend.components.questions.inputs')
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="col-12">
                                {!! $question->question !!}
                            </div>
                        </div>
                        @if($question->questionimage!==null)
                            <div class="col-4">
                                <div class="col-12">
                                    <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                </div>
                            </div>
                        @endif
                    </div>
                @elseif($question->titlelocation == 'col-6 order-2' && $question->answerposition == 'col-8 order-1' && $question->imageposition == 'col-12 order-2')
                    <!-- question,answer,image in same row but first answer,second image and third is question -->
                    <div class="row">
                        <div class="col-4">
                            <div class="col-12">
                                @include('frontend.components.questions.inputs')
                            </div>
                        </div>
                        @if($question->questionimage!==null)
                            <div class="col-4">
                                <div class="col-12">
                                    <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                </div>
                            </div>
                        @endif
                        <div class="col-4">
                            <div class="col-12">
                                {!! $question->question !!}
                            </div>
                        </div>
                    </div>
                @elseif($question->titlelocation == 'col-6 order-2' && $question->answerposition == 'col-12 order-3' && $question->imageposition == 'col-4 order-1')
                    <!-- Image(Right) and question(left) and answer bottom of both -->
                        <div class="row">
                            <div class="col-6">
                                {!! $question->question !!}
                            </div>
                            @if($question->questionimage!==null)
                                <div class="col-6">
                                    <div class="{{$imagealigment}}">
                                        <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                                <div class="col-12">
                                    @include('frontend.components.questions.inputs')
                                </div>
                        </div>
                @elseif($question->titlelocation == 'col-12 order-2' && $question->answerposition == 'col-12 order-1' && $question->imageposition == 'col-12 order-3')
                    <!-- Image(bottom) and question(center) and answer (top) -->
                    
                    <div class="row"> 
                        <div class="{{$aligment}}">
                                @include('frontend.components.questions.inputs')
                            </div>
                        </div>
                    <div class="row">
                            <div class="col-12">
                                {!! $question->question !!}
                            </div>
                    </div>
                    <div class="row">
                        @if($question->questionimage!==null)
                                <div class="col-12">
                                    <div class="{{$imagealigment}}">
                                        <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                    </div>
                                </div>
                            @endif
                    </div>
                @elseif($question->answerposition == 'col-12 order-3' && $question->imageposition == 'col-12 order-2')
                    <!-- Image(bottom) and question(center) and answer (top) -->
                    <div class="row">
                        @if($question->questionimage!==null)
                            <div class="col-12">
                                <div class="{{$imagealigment}}">
                                    <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="row"> 
                        <div class="{{$aligment}}">
                            @include('frontend.components.questions.inputs')
                        </div>
                    </div>
                    
                @elseif($question->titlelocation == 'col-12 order-3' && $question->answerposition == 'col-12 order-1' && $question->imageposition == 'col-12 order-2')
                    <!-- Image(center) and question(bottom) and answer (top) -->
                    
                    <div class="row"> 
                        <div class="{{$aligment}}">
                                @include('frontend.components.questions.inputs')
                            </div>
                        </div>
                    <div class="row">
                            @if($question->questionimage!==null)
                                <div class="col-12">
                                    <div class="{{$imagealigment}}">
                                        <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                    </div>
                                </div>
                            @endif
                                
                    </div>
                    <div class="row">
                            {!! $question->question !!}
                    </div>
                @elseif($question->titlelocation == 'col-12 order-3' && $question->imageposition == 'col-4 order-2' && $question->answerposition == 'col-8 order-1')
                    <!-- answer,image in same row but first answer,second image and quesion on top -->
                    
                    <div class="row">
                        <div class="col-8">
                            <div class="row">
                                <div class="{{$aligment}}">
                                    @include('frontend.components.questions.inputs')
                                </div>
                            </div>
                        </div>
                        @if($question->questionimage!==null)
                        <div class="col-4">
                            <div class="{{$imagealigment}}">
                                <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                            </div>
                        </div>
                        @endif
                    
                    </div>
                    <div class="row">
                        <div class="col-12">
                        {!! $question->question !!}
                        </div>
                    </div>
                @elseif($question->titlelocation == 'col-6 order-2' && $question->answerposition == 'col-8 order-1' && $question->imageposition == 'col-12 order-3')
                    <!-- Image(bottom) and question(right) and answer (left) -->
                    <div class="row">
                        <div class="col-6">
                                <div class="{{$aligment}}">
                                    @include('frontend.components.questions.inputs')
                                </div>
                        </div>
                        <div class="col-6">
                            {!! $question->question !!}
                        </div>
                    </div>
                    @if($question->questionimage!==null)
                    <div class="row">
                            <div class="col-12">
                                <div class="{{$imagealigment}}">
                                    <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                </div>
                            </div>
                    </div>
                    @endif
                @elseif($question->titlelocation == 'col-12 order-3' && $question->answerposition == 'col-12 order-2' && $question->imageposition == 'col-12 order-1')
                    <!-- Image(center) and question(bottom) and answer (top) -->
                    
                        <div class="row">
                            @if($question->questionimage!==null)
                                <div class="col-12">
                                    <div class="{{$imagealigment}}">
                                        <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                    </div>
                                </div>
                            @endif
                                
                    </div>
                    <div class="row"> 
                        <div class="{{$aligment}}">
                                @include('frontend.components.questions.inputs')
                            </div>
                        </div>
                    
                    <div class="row">
                        <div class="col-12">
                            {!! $question->question !!}
                        </div>
                            
                    </div>
                @elseif($question->imageposition == 'col-4 order-1' && $question->answerposition == 'col-8 order-2')
                    <!-- answer,image in same row but first image,second answer and quesion on top -->
                    <div class="row">
                        @if($question->questionimage!==null)
                        <div class="col-4">
                            <div class="{{$imagealigment}}">
                                <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                            </div>
                        </div>
                        @endif
                        <div class="col-8">
                            <div class="row">
                                <div class="{{$aligment}}">
                                    @include('frontend.components.questions.inputs')
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($question->imageposition == 'col-4 order-2' && $question->answerposition == 'col-8 order-1')
                    <!-- answer,image in same row but first answer,second image and quesion on top -->
                    <div class="row">
                        <div class="col-8">
                            <div class="row">
                                <div class="{{$aligment}}">
                                    @include('frontend.components.questions.inputs')
                                </div>
                            </div>
                        </div>
                        @if($question->questionimage!==null)
                        <div class="col-4">
                            <div class="{{$imagealigment}}">
                                <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                            </div>
                        </div>
                        @endif
                    </div>
                @elseif($question->imageposition == 'col-12 order-3' && $question->answerposition == 'col-12 order-2')
                    <!-- answer center, image Bottom and quesion on top -->
                
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="{{$aligment}}">
                                        @include('frontend.components.questions.inputs')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @if($question->questionimage!==null)
                            <div class="col-12">
                                <div class="{{$imagealigment}}">
                                    <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                </div>
                            </div>
                            @endif
                        </div>
                @elseif($question->imageposition == 'col-4 order-2' && $question->answerposition == 'col-12 order-2')
                    <!-- answer,image in same row but first answer,second image and quesion on top -->
                    
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="{{$aligment}}">
                                        @include('frontend.components.questions.inputs')
                                    </div>
                                </div>
                            </div>
                        <div>
                    
                        @if($question->questionimage!==null)
                            <div class="row">
                                <div class="col-12">
                                    <div class="{{$imagealigment}}">
                                        <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                    </div>
                                </div>
                            </div>
                        @endif
                @elseif($question->imageposition == 'col-12 order-2' && $question->answerposition == 'col-12 order-3')
                
                    <!-- answer,image in same row but first answer,second image and quesion on top -->
                    
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="{{$aligment}}">
                                        @include('frontend.components.questions.inputs')
                                    </div>
                                </div>
                            </div>
                        <div>
                    
                        @if($question->questionimage!==null)
                            <div class="row">
                                <div class="col-12">
                                    <div class="{{$imagealigment}}">
                                        <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                    </div>
                                </div>
                            </div>
                        @endif
                @endif
                @php
                    $content = json_decode($question->content);
                    $logic_content = json_decode($question->logic);
                
                @endphp
                @switch($question->titlelocation)
                    @case("default")
                        
                    @case("deafult")
                    
                    @case("left")
                        @php
                            $left = 8;
                            $right = 4;
                            if($question->questionimage==null)
                            {
                                $left=12;
                                $right=12;
                            }
                        @endphp
                        <div class="row">
                            <div class="col-md-{{$left}}">
                            <span class="q_number my-auto">{{$q_number++}}</span>
                                <h2 class="">
                                    <span class="">{!! $question->question !!}</span>
                                    
                                </h2>
                                <hr />
                                @include('frontend.components.questions.inputs')
                            </div>
                            <div class="col-md-{{$right}} mt-2">
                                @if($question->questionimage!==null)
                                    <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                @endif
                            </div>
                        </div>
                        @break
                    @case("hidden")
                        @php
                            $left = 8;
                            $right = 4;
                            if($question->questionimage==null)
                            {
                                $left=12;
                                $right=12;
                            }
                        @endphp
                        <div class="row">
                            <div class="col-md-{{$left}}">
                            <span class="q_number my-auto">{{$q_number++}}</span>
                            <div class="row">
                                <div class="col-10">
                                    @include('frontend.components.questions.inputs')
                                </div>
                                <div class="col-2">
                                    
                                </div>
                            </div>
                                
                            </div>
                            <div class="col-md-{{$right}} mt-2">
                                @if($question->questionimage!==null)
                                    <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                @endif
                            </div>
                        </div>
                        @break
                    @case("right")
                        @php
                            $left = 4;
                            $right = 8;
                            if($question->questionimage==null)
                            {
                                $left=12;
                                $right=12;
                            }
                        @endphp
                        <div class="row">
                            <div class="col-md-{{$left}}">
                                @if($question->questionimage!==null)
                                    <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                @endif
                            </div>
                            <div class="col-md-{{$right}}">
                                <h2 class="d-inline-flex question-heading">
                                
                                    <span class="q_number my-auto">{{$q_number++}}</span>
                                    <span class="">{!! $question->question !!}</span>
                                    
                                </h2>
                                <hr />
                                @include('frontend.components.questions.inputs')
                            </div>
                        </div>
                        @break
                    @case("top")
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="d-inline-flex question-heading">
                                
                                    <span class="q_number my-auto">{{$q_number++}}</span>
                                    <span class="">{!! $question->question !!}</span>
                                    
                                </h2>
                                <hr />
                                @include('frontend.components.questions.inputs')
                            </div>
                            <div class="col-md-12">
                                @if($question->questionimage!==null)
                                    <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                @endif
                            </div>
                        </div>
                        @break
                    @case("bottom")
                        <div class="row">
                            <div class="col-md-12">
                                @if($question->questionimage!==null)
                                    <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                @endif
                            </div>
                            <div class="col-md-12">
                                <h2 class="d-inline-flex question-heading">
                                
                                    <span class="q_number my-auto">{{$q_number++}}</span>
                                    <span class="">{!! $question->question !!}</span>
                                    
                                </h2>
                                <hr />
                                @include('frontend.components.questions.inputs')
                            </div>
                        </div>
                        @break
                        
                    @endswitch
            
                
                {{-- Hidden Information --}}
                <div class="hidden-information">
                    <input type="hidden" class="qt_type" value="{{ $question->questiontype }}">
                    <input type="hidden" class="logic_cnt" value="{{ count($logic_content) }}">
                </div>
                <input type="hidden" id="displayed_answer" value="0">
                @for ($k=0;$k< count($logic_content);$k++)
                    <div class="logic_{{ $k }}">
                        <input type="hidden" class="logic_type" value="{{ $logic_content[$k][0] }}">
                        <input type="hidden" class="logic_qt" value="{{ $logic_content[$k][1] }}">
                        <input type="hidden" class="logic_operator" value="{{ $logic_content[$k][2] }}">
                        @foreach($logic_content[$k][3] as $key => $value)
                            <input type="hidden" class="{{'logic_cont '.$key}}" name="logic_cont[]" value="{{ $value }}">
                        @endforeach
                        <input type="hidden" class="logic_state" value="0">
                    </div>
                @endfor
                {{-- End Hidden Information --}}
            </div>
            </form>
            
        </div>
        
    @else
        <div id="q_{{$question->id}}" class="question-card card custom-card mb-3 p-2" data-page="{{$question->page_number}}" style="background-color:{{($question->question_bg_color != '')?$question->question_bg_color:'#fff'}};box-shadow: 1px 1px 6px {{($question->question_bg_color != '' && $question->question_bg_color != '#fff')?'2px':'-3px'}}  {{($question->question_bg_color != '' && $question->question_bg_color != '#fff')?$question->question_bg_color:'#000'}};">
            
            <form id="checkForm">
            <div class="row">
                    <div class="col-2 p-0"><span class="q_number gradient-bg my-auto" style="background:{{$lesson->color1}};{{$text1}}">{{$q_number++}}</span></div>
                    <div class="col-8 p-0">
                        
                        @if($question->titlelocation == 'col-12 order-1')
                        {!! html_entity_decode($question->question) !!}
                        <!-- <h2 class="d-inline-flex question-heading  w-100">
                            <span class="">{!! html_entity_decode($question->question) !!}</span>
                        <h2> -->
                        @endif
                    </div>
                    @if(!$question->required)
                        @php
                            $col = 4;
                        @endphp
                    @else
                        @php
                            $col = 2;
                        @endphp
                    @endif
                    @php 
                            if(isset($question->answer_aligment)){
                                if(($question->answer_aligment == 'offset-md-0')){
                                    $aligment = 'col-12 '.$question->answer_aligment;
                                }else{
                                    $aligment = $question->answer_aligment;
                                }
                            }else{
                                $aligment = 'col-12';
                            }  
                            if(isset($question->image_aligment)){
                                if(($question->image_aligment == 'offset-md-0')){
                                    $imagealigment = 'col-12 '.$question->image_aligment;
                                }else{
                                    $imagealigment = $question->image_aligment;
                                }
                            }else{
                                $imagealigment = 'col-12';
                            }
                            
                        @endphp
                    <div class="col-2 p-0 text-right ">
                        @if($question->help_info != "")
                            <span data-toggle="modal" data-target="#exampleModalLong{{$question->id}}" style="" class="d-inline-block mr-2">
                                <i style="color:{{$lesson->color1}};font-size: 24px;margin-top: 8px;" class="fas fa-question-circle"></i></span>
                        @endif
                        @include('frontend.components.questions.required')
                    </div>
                </div>
                <hr>
            <div class="card-body">
                @if($question->titlelocation == 'col-12' && $question->answerposition == 'col-12' && $question->imageposition == 'col-12')
                    <!-- question,answer,image in same row but first question,second image and third is answer -->
                    <div class="row">
                        <div class="{{$question->titlelocation}}">
                            <h2 class="">
                                <span class="">{!! $question->question !!}</span>
                            </h2>
                            <hr />
                        </div>
                        @if($question->questionimage!==null)
                        <div class="{{$question->imageposition}}">
                            <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                        </div>
                        @endif
                        <div class="{{$aligment}}">
                            @include('frontend.components.questions.inputs')
                        </div>
                    </div>
                @elseif($question->titlelocation == 'col-12 order-2' && $question->answerposition == 'col-8 order-2' && $question->imageposition == 'col-4 order-1')
                    <!-- question,answer,image in same row but first image,second question and third is answer -->      
                    <div class="row">
                        @if($question->questionimage!==null)
                        <div class="col-4">
                            <div class="{{$imagealigment}}">
                                <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                            </div>
                        </div>
                        @endif
                        <div class="col-4">
                            <div class="col-12">
                                {!! $question->question !!}
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="{{$aligment}}">
                                @include('frontend.components.questions.inputs')
                            </div>
                        </div>
                    </div>
                @elseif($question->titlelocation == 'col-6 order-1' && $question->answerposition == 'col-8 order-2' && $question->imageposition == 'col-12 order-2')
                    <!-- question,answer,image in same row but first question,second image and third is answer -->
                    <div class="row">
                        <div class="col-4">
                            <div class="col-12">
                                {!! $question->question !!}
                            </div>
                        </div>
                        @if($question->questionimage!==null)
                        <div class="col-4">
                            <div class="col-12">
                                <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                            </div>
                        </div>
                        @endif
                        <div class="col-4">
                            <div class="col-12">
                                @include('frontend.components.questions.inputs')
                            </div>
                        </div>
                    </div>
                @elseif($question->titlelocation == 'col-6 order-2' && $question->answerposition == 'col-12 order-2' && $question->imageposition == 'col-4 order-1')
                    <!-- question,answer,image in same row but first question,second answer and third is image -->
                    <div class="row">
                        <div class="col-4">
                            <div class="col-12">
                                {!! $question->question !!}
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="col-12">
                                @include('frontend.components.questions.inputs')
                            </div>
                        </div>
                        @if($question->questionimage!==null)
                            <div class="col-4">
                                <div class="col-12">
                                    <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                </div>
                            </div>
                        @endif
                    </div>
                @elseif($question->titlelocation == 'col-6 order-1' && $question->answerposition == 'col-12 order-2' && $question->imageposition == 'col-4 order-2')
                    <!-- question,answer,image in same row but first image,second answer and third is question -->
                    <div class="row">
                        @if($question->questionimage!==null)
                            <div class="col-4">
                                <div class="col-12">
                                    <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                </div>
                            </div>
                        @endif
                        
                        <div class="col-4">
                            <div class="col-12">
                                @include('frontend.components.questions.inputs')
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="col-12">
                                {!! $question->question !!}
                            </div>
                        </div>
                    </div>
                @elseif($question->titlelocation == 'col-12 order-2' && $question->answerposition == 'col-8 order-1' && $question->imageposition == 'col-4 order-1')
                    <!-- question,answer,image in same row but first answer,second question and third is image -->
                    <div class="row">
                        <div class="col-4">
                            <div class="col-12">
                                @include('frontend.components.questions.inputs')
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="col-12">
                                {!! $question->question !!}
                            </div>
                        </div>
                        @if($question->questionimage!==null)
                            <div class="col-4">
                                <div class="col-12">
                                    <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                </div>
                            </div>
                        @endif
                    </div>
                @elseif($question->titlelocation == 'col-6 order-2' && $question->answerposition == 'col-8 order-1' && $question->imageposition == 'col-12 order-2')
                    <!-- question,answer,image in same row but first answer,second image and third is question -->
                    <div class="row">
                        <div class="col-4">
                            <div class="col-12">
                                @include('frontend.components.questions.inputs')
                            </div>
                        </div>
                        @if($question->questionimage!==null)
                            <div class="col-4">
                                <div class="col-12">
                                    <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                </div>
                            </div>
                        @endif
                        <div class="col-4">
                            <div class="col-12">
                                {!! $question->question !!}
                            </div>
                        </div>
                    </div>
                @elseif($question->titlelocation == 'col-6 order-2' && $question->answerposition == 'col-12 order-3' && $question->imageposition == 'col-4 order-1')
                    <!-- Image(Right) and question(left) and answer bottom of both -->
                        <div class="row">
                            <div class="col-6">
                                {!! $question->question !!}
                            </div>
                            @if($question->questionimage!==null)
                                <div class="col-6">
                                    <div class="{{$imagealigment}}">
                                        <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                                <div class="col-12">
                                    @include('frontend.components.questions.inputs')
                                </div>
                        </div>
                @elseif($question->titlelocation == 'col-12 order-2' && $question->answerposition == 'col-12 order-1' && $question->imageposition == 'col-12 order-3')
                    <!-- Image(bottom) and question(center) and answer (top) -->
                    
                    <div class="row"> 
                        <div class="{{$aligment}}">
                                @include('frontend.components.questions.inputs')
                            </div>
                        </div>
                    <div class="row">
                            <div class="col-12">
                                {!! $question->question !!}
                            </div>
                    </div>
                    <div class="row">
                        @if($question->questionimage!==null)
                                <div class="col-12">
                                    <div class="{{$imagealigment}}">
                                        <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                    </div>
                                </div>
                            @endif
                    </div>
                @elseif($question->answerposition == 'col-12 order-3' && $question->imageposition == 'col-12 order-2')
                    <!-- Image(bottom) and question(center) and answer (top) -->
                        <div class="row">
                        @if($question->questionimage!==null)
                                <div class="col-12">
                                    <div class="{{$imagealigment}}">
                                        <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                    </div>
                                </div>
                            @endif
                    </div>
                    <div class="row"> 
                        <div class="{{$aligment}}">
                                @include('frontend.components.questions.inputs')
                            </div>
                        </div>
                    
                @elseif($question->titlelocation == 'col-12 order-3' && $question->answerposition == 'col-12 order-1' && $question->imageposition == 'col-12 order-2')
                    <!-- Image(center) and question(bottom) and answer (top) -->
                    
                    <div class="row"> 
                        <div class="{{$aligment}}">
                                @include('frontend.components.questions.inputs')
                            </div>
                        </div>
                    <div class="row">
                            @if($question->questionimage!==null)
                                <div class="col-12">
                                    <div class="{{$imagealigment}}">
                                        <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                    </div>
                                </div>
                            @endif
                                
                    </div>
                    <div class="row">
                            {!! $question->question !!}
                    </div>
                @elseif($question->titlelocation == 'col-12 order-3' && $question->imageposition == 'col-4 order-2' && $question->answerposition == 'col-8 order-1')
                    <!-- answer,image in same row but first answer,second image and quesion on top -->
                    
                    <div class="row">
                        <div class="col-8">
                            <div class="row">
                                <div class="{{$aligment}}">
                                    @include('frontend.components.questions.inputs')
                                </div>
                            </div>
                        </div>
                        @if($question->questionimage!==null)
                        <div class="col-4">
                            <div class="{{$imagealigment}}">
                                <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                            </div>
                        </div>
                        @endif
                    
                    </div>
                    <div class="row">
                        <div class="col-12">
                        {!! $question->question !!}
                        </div>
                    </div>
                @elseif($question->titlelocation == 'col-6 order-2' && $question->answerposition == 'col-8 order-1' && $question->imageposition == 'col-12 order-3')
                    <!-- Image(bottom) and question(right) and answer (left) -->
                    <div class="row">
                        <div class="col-6">
                                <div class="{{$aligment}}">
                                    @include('frontend.components.questions.inputs')
                                </div>
                        </div>
                        <div class="col-6">
                            {!! $question->question !!}
                        </div>
                    </div>
                    @if($question->questionimage!==null)
                    <div class="row">
                            <div class="col-12">
                                <div class="{{$imagealigment}}">
                                    <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                </div>
                            </div>
                    </div>
                    @endif
                @elseif($question->titlelocation == 'col-12 order-3' && $question->answerposition == 'col-12 order-2' && $question->imageposition == 'col-12 order-1')
                    <!-- Image(center) and question(bottom) and answer (top) -->
                    
                        <div class="row">
                            @if($question->questionimage!==null)
                                <div class="col-12">
                                    <div class="{{$imagealigment}}">
                                        <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                    </div>
                                </div>
                            @endif
                                
                    </div>
                    <div class="row"> 
                        <div class="{{$aligment}}">
                                @include('frontend.components.questions.inputs')
                            </div>
                        </div>
                    
                    <div class="row">
                        <div class="col-12">
                            {!! $question->question !!}
                        </div>
                            
                    </div>
                @elseif($question->imageposition == 'col-4 order-1' && $question->answerposition == 'col-8 order-2')
                    <!-- answer,image in same row but first image,second answer and quesion on top -->
                    <div class="row">
                        @if($question->questionimage!==null)
                        <div class="col-4">
                            <div class="{{$imagealigment}}">
                                <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                            </div>
                        </div>
                        @endif
                        <div class="col-8">
                            <div class="row">
                                <div class="{{$aligment}}">
                                    @include('frontend.components.questions.inputs')
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($question->imageposition == 'col-4 order-2' && $question->answerposition == 'col-8 order-1')
                    <!-- answer,image in same row but first answer,second image and quesion on top -->
                    <div class="row">
                        <div class="col-8">
                            <div class="row">
                                <div class="{{$aligment}}">
                                    @include('frontend.components.questions.inputs')
                                </div>
                            </div>
                        </div>
                        @if($question->questionimage!==null)
                        <div class="col-4">
                            <div class="{{$imagealigment}}">
                                <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                            </div>
                        </div>
                        @endif
                    </div>
                @elseif($question->imageposition == 'col-12 order-3' && $question->answerposition == 'col-12 order-2')
                    <!-- answer center, image Bottom and quesion on top -->
                
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="{{$aligment}}">
                                        @include('frontend.components.questions.inputs')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @if($question->questionimage!==null)
                            <div class="col-12">
                                <div class="{{$imagealigment}}">
                                    <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                </div>
                            </div>
                            @endif
                        </div>
                @elseif($question->imageposition == 'col-4 order-2' && $question->answerposition == 'col-12 order-2')
                    <!-- answer,image in same row but first answer,second image and quesion on top -->
                    
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="{{$aligment}}">
                                        @include('frontend.components.questions.inputs')
                                    </div>
                                </div>
                            </div>
                        <div>
                    
                        @if($question->questionimage!==null)
                            <div class="row">
                                <div class="col-12">
                                    <div class="{{$imagealigment}}">
                                        <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                    </div>
                                </div>
                            </div>
                        @endif
                @elseif($question->imageposition == 'col-12 order-2' && $question->answerposition == 'col-12 order-3')
                
                    <!-- answer,image in same row but first answer,second image and quesion on top -->
                    
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="{{$aligment}}">
                                        @include('frontend.components.questions.inputs')
                                    </div>
                                </div>
                            </div>
                        <div>
                    
                        @if($question->questionimage!==null)
                            <div class="row">
                                <div class="col-12">
                                    <div class="{{$imagealigment}}">
                                        <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                    </div>
                                </div>
                            </div>
                        @endif
                
                @endif
                @php
                    $content = json_decode($question->content);
                    $logic_content = json_decode($question->logic);
                
                @endphp
                @switch($question->titlelocation)
                    @case("default")
                        
                    @case("deafult")
                    
                    @case("left")
                        @php
                            $left = 8;
                            $right = 4;
                            if($question->questionimage==null)
                            {
                                $left=12;
                                $right=12;
                            }
                        @endphp
                        <div class="row">
                            <div class="col-md-{{$left}}">
                            <span class="q_number my-auto">{{$q_number++}}</span>
                                <h2 class="">
                                    <span class="">{!! $question->question !!}</span>
                                    
                                </h2>
                                <hr />
                                @include('frontend.components.questions.inputs')
                            </div>
                            <div class="col-md-{{$right}} mt-2">
                                @if($question->questionimage!==null)
                                    <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                @endif
                            </div>
                        </div>
                        @break
                    @case("hidden")
                        @php
                            $left = 8;
                            $right = 4;
                            if($question->questionimage==null)
                            {
                                $left=12;
                                $right=12;
                            }
                        @endphp
                        <div class="row">
                            <div class="col-md-{{$left}}">
                            <span class="q_number my-auto">{{$q_number++}}</span>
                            <div class="row">
                                <div class="col-10">
                                    @include('frontend.components.questions.inputs')
                                </div>
                                <div class="col-2">
                                    
                                </div>
                            </div>
                                
                            </div>
                            <div class="col-md-{{$right}} mt-2">
                                @if($question->questionimage!==null)
                                    <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                @endif
                            </div>
                        </div>
                        @break
                    @case("right")
                        @php
                            $left = 4;
                            $right = 8;
                            if($question->questionimage==null)
                            {
                                $left=12;
                                $right=12;
                            }
                        @endphp
                        <div class="row">
                            <div class="col-md-{{$left}}">
                                @if($question->questionimage!==null)
                                    <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                @endif
                            </div>
                            <div class="col-md-{{$right}}">
                                <h2 class="d-inline-flex question-heading">
                                
                                    <span class="q_number my-auto">{{$q_number++}}</span>
                                    <span class="">{!! $question->question !!}</span>
                                    
                                </h2>
                                <hr />
                                @include('frontend.components.questions.inputs')
                            </div>
                        </div>
                        @break
                    @case("top")
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="d-inline-flex question-heading">
                                
                                    <span class="q_number my-auto">{{$q_number++}}</span>
                                    <span class="">{!! $question->question !!}</span>
                                    
                                </h2>
                                <hr />
                                @include('frontend.components.questions.inputs')
                            </div>
                            <div class="col-md-12">
                                @if($question->questionimage!==null)
                                    <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                @endif
                            </div>
                        </div>
                        @break
                    @case("bottom")
                        <div class="row">
                            <div class="col-md-12">
                                @if($question->questionimage!==null)
                                    <img src="{{asset('uploads/image/'.$question->questionimage)}}" width="{{$question->imagewidth}}">
                                @endif
                            </div>
                            <div class="col-md-12">
                                <h2 class="d-inline-flex question-heading">
                                
                                    <span class="q_number my-auto">{{$q_number++}}</span>
                                    <span class="">{!! $question->question !!}</span>
                                    
                                </h2>
                                <hr />
                                @include('frontend.components.questions.inputs')
                            </div>
                        </div>
                        @break
                        
                    @endswitch
            
                
                {{-- Hidden Information --}}
                <div class="hidden-information">
                    <input type="hidden" class="qt_type" value="{{ $question->questiontype }}">
                    <input type="hidden" class="logic_cnt" value="{{ count($logic_content) }}">
                </div>
                <input type="hidden" id="displayed_answer" value="0">
                @for ($k=0;$k< count($logic_content);$k++)
                    <div class="logic_{{ $k }}">
                        <input type="hidden" class="logic_type" value="{{ $logic_content[$k][0] }}">
                        <input type="hidden" class="logic_qt" value="{{ $logic_content[$k][1] }}">
                        <input type="hidden" class="logic_operator" value="{{ $logic_content[$k][2] }}">
                        @foreach($logic_content[$k][3] as $key => $value)
                            <input type="hidden" class="{{'logic_cont '.$key}}" name="logic_cont[]" value="{{ $value }}">
                        @endforeach
                        <input type="hidden" class="logic_state" value="0">
                    </div>
                @endfor
                {{-- End Hidden Information --}}
            </div>
            </form>
            
        </div>
    @endif
@endforeach
</div>

<form style="display:none;" method="post" id="pdfform" action="{{ route('generate-pdf') }}" enctype="multipart/form-data">
  @csrf
  <input type="hidden" id="image_data" name="image_data">
</form>


<!-- Add the loading spinner HTML element -->
<div id="loader" class="text-center" style="display: none;">
  <!-- Spinning icon from Font Awesome -->
  <p>
  <i class="fas fa-spinner fa-spin"></i>
  <br>
    Reports are generating, please do not refresh or return to the page until done.
    Once completed, you will get a pdf file .
  </p>
<!--   <p>
    I rapporti vengono generati, quindi non aggiornare o tornare alla pagina fino al completamento.
    Una volta completato, è possibile visualizzare il PDF nel menu laterale.
  </p> -->
</div>



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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{asset('js/utils.js')}}"></script>

@php
    $temp=explode('style="',$lesson->text1);
    $btnstyle="";
    foreach($temp as $index)
        if(strrpos($index,'"')>0)
            $btnstyle=$btnstyle.substr($index,0,strrpos($index,'"')).';';
@endphp
<script>

    function convertNumberFormat(inputValue) {
        var replacedValue = inputValue.replace(/,/g, '#'); // Replace all commas with a temporary character '#'
        replacedValue = replacedValue.replace(/\./g, ','); // Replace all periods with commas
        replacedValue = replacedValue.replace(/#/g, '.'); // Replace all temporary characters '#' with periods

        return replacedValue;
    }
    
    function inputToData(ele){
        if(ele.type == 'radio'){
            $('.radioselected').each(function(el){
                $(this).removeClass('selected');
                $(this).attr('data-selected','false');
            });
            $(ele).addClass('selected');
            $(ele).attr('data-selected','true');
        }else{
            
            if(!isNaN(ele.value)){
                ele.value=Number(ele.value).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            }
            var italicFrom  = convertNumberFormat(ele.value);
            // alert(ele)
            // console.log(italicFrom);
            $(ele).data('value',italicFrom);
            $(ele).val(italicFrom);
            $('.q_id'+ele.dataset.q_id).data('value',italicFrom);
        }
    }
    $("body").append(`<style>#create-report {<?php echo $btnstyle;?>}</style>`)
    var el=$(".q_number")[0];
    var size=parseFloat(window.getComputedStyle(el, null).getPropertyValue('font-size'))+10;
    console.log(size);
    $("body").append(`<style>.q_number{width:${size}px;height:${size}px;line-height:${size}px;}</style>`)
    var len=$(".img_canvas").length;
    var style = window.getComputedStyle(el);
    function getRGB(str){
      var match = str.match(/rgb?\((\d{1,3}), ?(\d{1,3}), ?(\d{1,3})\)?(?:, ?(\d(?:\.\d?))\))?/);
      return match ? {
        red: match[1],
        green: match[2],
        blue: match[3]
      } : {};
    }
    for(var i=0;i<len;i++)
    {
        var img = new Image();
        img.crossOrigin = "anonymous";
        img.src = "../../storage/logos/help.png";
        var canvas = $(".img_canvas")[i];
        var ctx = canvas.getContext("2d");
        ctx.drawImage(img,29, 35);
        img.style.display = "none";
        var width = img.width;
        var height = img.height;
        for(var j=0;j<canvas.width;j++)
            for(var k=0;k<canvas.height;k++)
            {
                var pixel = ctx.getImageData(j, k, 1, 1);
                var data = pixel.data;
                {
                    pixel.data[0]=getRGB(style.backgroundColor)['red'];
                    pixel.data[1]=getRGB(style.backgroundColor)['green'];
                    pixel.data[2]=getRGB(style.backgroundColor)['blue'];
                }   
                
                ctx.putImageData(pixel,j,k);
            }
    }
</script>

