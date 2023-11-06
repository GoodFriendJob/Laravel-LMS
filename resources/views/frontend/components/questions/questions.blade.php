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
  .curserPointQue{
    cursor: pointer;
  }
</style>
<div class="question-ans">
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
        //echo $lesson->text1;
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
    <?php
    preg_match('/font-size:(\d+px)/', $text2, $matches);
    $firstFontSize = $matches[1] ?? null;
    preg_match('/font-style:([^;]*)/', $text2, $matches1);
    $firstStyle = $matches1[1] ?? null;
    preg_match('/font-family:([^;]*)/', $text2, $matches2);
    $firstFamily = $matches2[1] ?? null;

    preg_match('/font-size:(\d+px)/', $text1, $matches);
    $firstFontSize1 = $matches[1] ?? null;
    preg_match('/font-style:([^;]*)/', $text1, $matches11);
    $firstStyle1 = $matches11[1] ?? null;
    preg_match('/font-family:([^;]*)/', $text1, $matches12);
    $firstFamily1 = $matches12[1] ?? null;
    
    ?>

    <script>
            $("body").append(`<style>#q_<?php echo $question->id?> .col-8.p-0{<?php echo $fontstyle1?>}</style>`)
    </script>
    <!-- style="background-color:{{$lesson->color1}};font-size:{{$firstFontSize}};font-style:{{$firstStyle}};font-family:{{$firstFamily}}" -->
    <input  type='hidden' id='firstFontSize' value='{{$firstFontSize}}' />
    <input  type='hidden' id='firstStyle' value='{{$firstStyle}}' />
    <input  type='hidden' id='firstFamily' value='{{$firstFamily}}' />
    @if(in_array($question->id,$ids))
        <div id="q_{{$question->id}}" class="question-card card custom-card mb-3" data-page="{{$question->page_number}}" style="font-size:{{$firstFontSize1}};font-style:{{$firstStyle1}};font-family:{{$firstFamily1}};background-color:{{($question->question_bg_color != '')?$question->question_bg_color:'#fff'}};box-shadow: 1px 1px 6px {{($question->question_bg_color != '' && $question->question_bg_color != '#fff')?'2px':'-3px'}}  {{($question->question_bg_color != '' && $question->question_bg_color != '#fff')?$question->question_bg_color:'#fff'}};">
            <form id="checkForm">
            <div class="row">
                    <div class="col-2 p-0"><span class="q_number gradient-bg my-auto p-2" style="color:<?php if($lesson->color2 != ""){ echo $lesson->color2;  }else{ echo "black";}  ?>;background:{{$lesson->color1}};">{{$q_number++}}</span></div>
                    <div class="col-8 p-0 curserPointQue">
                        @if($question->titlelocation == 'col-12 order-1')
                        {!! html_entity_decode($question->question) !!}
                      
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
                        @if($question->help_info != "" && $question->access_help_info == 1)
                            <span data-toggle="modal" data-target="#helpModel" onclick='getHelpForModel({{$question->id}})' class="d-inline-block mr-2">{{$question->access_help_info}}<i style="color:<?php if($lesson->color2 != ""){ echo $lesson->color2;  }else{ echo "black";}  ?>;font-size:{{$firstFontSize1}};" class="fas fa-question-circle"></i></span>
                        @endif
                        <script type="text/javascript">
                            getQustionGraph({{$question->id}});
                        </script>
                        @include('frontend.components.questions.required')
                    </div>
                </div>
                <hr>
            <div class="card-body">
                @if($question->titlelocation == 'col-12' && $question->answerposition == 'col-12' && $question->imageposition == 'col-12')

                    <!-- question,answer,image in same row but first question,second image and third is answer -->
                    <div class="row">
                        <div class="{{$question->titlelocation}}">
                            <h2 class="curserPointQue" >
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
                    <input type='hidden' value='{{$q_number}}' id='quesno{{$question->id}}' />
                    <div class="col-2 p-0"><span class="q_number gradient-bg my-auto" style="color:<?php if($lesson->color2 != ""){ echo $lesson->color2;  }else{ echo "black";}  ?>;font-size:{{$firstFontSize1}};font-style:{{$firstStyle1}};font-family:{{$firstFamily1}};background:{{$lesson->color1}};">{{$q_number++}}</span></div>
                    <div class="col-8 p-0 curserPointQue" >
                        <div id="dynamic_chart{{$question->id}}"></div>
                        @php $chartIdPart = extractChartId(html_entity_decode($question->question)); 
                        
                        @endphp
                        @if($question->titlelocation == 'col-12 order-1')
                        <p style='font-size:{{$firstFontSize1}};font-style:{{$firstStyle1}};font-family:{{$firstFamily1}};'>{!! strip_tags($question->question) !!}</p>
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
                        @if($question->help_info != "" && $question->access_help_info == 1)
                            <span data-toggle="modal" data-target="#helpModel" onclick='getHelpForModel({{$question->id}})' style="" class="d-inline-block mr-2">
                                <i style="color:{{$lesson->color1}};font-size:{{$firstFontSize1}};margin-top: 8px;" class="fas fa-question-circle"></i></span>
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

<div class="report-card card mt-2" style="display: none;">
    <div class="card-body">
        <div id="report">
            
        </div>
    </div>
</div>

<!-- Add the loading spinner HTML element -->
<div id="loader" class="text-center" style="display: none;">
  <!-- Spinning icon from Font Awesome -->
  <p>
  <i class="fas fa-spinner fa-spin"></i>
  <br>
  @if(config('access.users.order_mail') == 1)
    Sending report to your email, Please wait..
    @else
    Reports are generating, please do not refresh or return to the page until done.
    Once completed, you can see the PDF in the side menu.
    @endif
  </p>
<!--   <p>
    I rapporti vengono generati, quindi non aggiornare o tornare alla pagina fino al completamento.
    Una volta completato, è possibile visualizzare il PDF nel menu laterale.
  </p> -->
</div>
<div class="text-right">
    <div id="navigation-btns" class="mb-2" style="">
        <button type="button" id="pre-pg" class="btn btn-danger">Previous</button>
        <button type="button" id="next-pg" class="btn btn-danger">Next</button>
    </div>
    {{-- <div id="navigation-btns" class="mb-2" style="">
        <button type="submit" id="pre-pg" class="btn btn-danger">Answer</button>
    </div> --}}
    <div class="genius-btn mt60  ml-auto custom-btn" id="report_div" style="width: 90px;">
    <?php
    preg_match('/font-size:(\d+px)/', $text2, $matches);
    $firstFontSize = $matches[1] ?? null;
    preg_match('/font-style:([^;]*)/', $text2, $matches1);
    $firstStyle = $matches1[1] ?? null;
    preg_match('/font-family:([^;]*)/', $text2, $matches2);
    $firstFamily = $matches2[1] ?? null;
    
    ?>
        <a style="color:<?php if($lesson->color2 != ""){ echo $lesson->color2;  }else{ echo "black";}  ?>; {{$lesson->color2}};background-color:{{$lesson->color1}};font-size:{{$firstFontSize}};font-style:{{$firstStyle}};font-family:{{$firstFamily}}" id="create-reports" href="javascript:void(0);" class="btn" >Report</a>
    </div>
    <div class="genius-btn mt60  ml-auto custom-btn" id="update_report_div" style="display: none; width: 130px;">
        <a id="update-report" href="javascript:void(0);" style="color:<?php if($lesson->color2 != ""){ echo $lesson->color2;  }else{ echo "black";}  ?>;background-color:{{$lesson->color1}};font-size:{{$firstFontSize}};font-style:{{$firstStyle}};font-family:{{$firstFamily}}"  class="btn">Save Report</a>
    </div>
    {{-- <div class="genius-btn mt60 gradient-bg ml-auto custom-btn" id="answer" style="width: 130px;">
        <button id="answer-submit" class="" style="border:none; background-color:inherit; color:white" type="submit">Answer</a>
    </div> --}}
</div>
<div class="modal fade" id="helpModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-white">
            <div class="modal-header backgroud-style p-0">
                <div class="gradient-bg"></div>
                <div class="popup-logo">
                    <img src="{{asset('storage/logos/popup-logo.png')}}" alt="">
                </div>
                <div class="popup-text text-center p-2">
                    <h2 class="mt-5">Guida</h2>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div id="modelHelp"></div>
                <div class="nws-button text-right white text-capitalize">
                    <button type="button"  style="height:unset;width:unset;font-size:1.2rem;" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
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
    
      function ExpressionCalculation(content, user_question) {
        
        for (var i = 1; i < content.length; i++) {
            for (var j = 1; j < content[i].length; j++) {
                var expression = [];
                expression = equation_extraction(content[i][j]);
                var infix_expression = expression;//infixToPostFix(expression);

                for (var k = 0; k < infix_expression.length; k++) {
                    if(infix_expression[k] == undefined || infix_expression[k] == "" || infix_expression[k] == null)
                        continue;
                    if (infix_expression[k].includes("question") == true) {
                        var q_item = infix_expression[k].split("question")[1];
                        for (var m = 0; m < user_question.length; m++) {
                            if (user_question[m]['q_id'] == q_item) {
                                infix_expression[k] = user_question[m]['score'];
                                break;
                            }
                            else
                                infix_expression[k] = 0;
                        }
                    }else if (infix_expression[k].includes("textgroup") == true) {
                        var t_item = infix_expression[k].split("textgroup")[1];
                        for (var m = 0; m < textgroup_scores.length; m++) {
                            if (textgroup_scores[m]['id'] == t_item) {
                                infix_expression[k] = textgroup_scores[m]['score'];
                                break;
                            }
                        }
                    }else if(infix_expression[k].includes("file") == true){
                        var q_item = infix_expression[k].split(".")[0];
                        var file_id = infix_expression[k].split(".")[2] - 1;
                        for(var m = 0; m < user_question.length; m++){
                            if(user_question[m]['q_id'] == q_item) {
                                files = JSON.parse(user_question[m]['answer']);
                                infix_expression[k] = file_element(files[file_id]);
                            }
                        }
                    }else{
                        let names = infix_expression[k].split(".");
                        if(names.length >= 3){
                            let num = names.length - 1;
                            $("table[name='matrix']").each(function (idx, ele) {
                                let id = $(this).data("id");
                                if(id === parseInt(names[0])){
                                    var value = 0;
                                    let input = $(this).find("input[id='q_id" + names[num] + "']");
                                    var row = $(input).parent().parent();
                                    let inputs = $(row).children().find('input[type="radio"]');
                                    if(inputs.length == 0){
                                        // inputs = $(row).children().find('input[type="text"]');
                                        // for(var i = 0; i < inputs.length; i++){
                                            value = $(input).val();
                                        // }
                                    }else {
                                        for(var i = 0; i < inputs.length; i++){
                                            if($(inputs[i]).is(':checked')){
                                                value = $(inputs[i]).val();
                                                break;
                                            }
                                        }
                                    }
                                    
                                    if(value == "" || value == null)
                                        value = 0;
                                    value = parseInt(value);
                                    infix_expression[k] = value;
                                }
                            })

                        }
                    }
                }

                content[i][j] = infix_expression;
                //console.log(infix_expression);
            }
        }
        for (var i = 1; i < content.length; i++) {
            for (var j = 1; j < content[i].length; j++) {
                content[i][j] = infix_evaluation(content[i][j]);
            }
        }
        return content;
    }

    function equation_extraction(origin_expression) {
        origin_expression=origin_expression.replace(",",".");
        var operator = ["+", "-", "*", "/", "(", ")"];
        var expression = [];
        expression[0] = "";
        var i = 0;
        var operator_flag = 0;
        for (var t = 0; t < origin_expression.length; t++) {
            operator_flag = 0;
            for (var j = 0; j < operator.length; j++) {
                if (origin_expression[t] == operator[j]) {
                    operator_flag = 1;
                    break;
                }
            }
            if (operator_flag == 0)
                expression[i] += origin_expression[t];
            else {
                if (expression[i].length > 0)
                    i++;
                expression[i] = operator[j];
                if (t != origin_expression.length - 1) {
                    i++;
                    expression[i] = "";
                }
            }

        }
        return expression;
    }

    function infix_evaluation(infix_expression) {
        var temp = [];
        let cnx = "";
        for( let j = 0; j < infix_expression.length; j++){
            cnx += infix_expression[j];
        }
        if(cnx.includes('<div') == true) {
            let formula = cnx;
            return formula;
        }
        cnx = cnx.replace("++", "+");
        cnx = cnx.replace("+*", "*");
        cnx = cnx.replace("+-", "-");
        cnx = cnx.replace("+/", "/");
        cnx = cnx.replace("-*", "*");
        cnx = cnx.replace("--", "-");
        cnx = cnx.replace("-+", "+");
        cnx = cnx.replace("-/", "/");
        cnx = cnx.replace("**", "*");
        cnx = cnx.replace("*-", "-");
        cnx = cnx.replace("*+", "+");
        cnx = cnx.replace("*/", "/");
        cnx = cnx.replace("/*", "*");
        cnx = cnx.replace("/-", "-");
        cnx = cnx.replace("/+", "+");
        cnx = cnx.replace("//", "/");
        cnx = cnx.replace("(+", "(");
        //cnx = cnx.replace(")+", ")");
        cnx = cnx.replace("(*", "(");
        //cnx = cnx.replace(")*", ")");
        cnx = cnx.replace("(-", "(");
        //cnx = cnx.replace(")-", ")");
        cnx = cnx.replace("(/", "(");
        cnx = cnx.replace("/)", ")");
        try {
            let formula = eval(cnx);
            return formula;
        }catch(e){
            return cnx;
        }

    }

    function drawChart(contents, chartids, types,idx) {
        // let idx = 1;
        for(let j = 0; j < contents.length; j++) {
            let content = contents[j];
            if (types[j] == 0) {
                pie_chart_draw(content, idx);
            } else if (types[j] == 1) {
                donut_chart_draw(content, idx);
            } else if (types[j] == 2) {
                bar_chart_draw(content, idx);
            } else if (types[j] == 3) {
                d3bar_chart_draw(content, idx);
            } else if(types[j] == 5) {
                horizontal_bar_chart_draw(content, idx);
            } else if(types[j] == 6) {
                line_chart_draw(content, idx);
            } else if(types[j] == 7) {
                radar_chart_draw(content, idx);
            } else if(types[j] == 8) {
                polar_chart_draw(content, idx);
            } else if(types[j] == 9) {
                bubble_chart_draw(content, idx);
            } else if(types[j] == 11) {
                radar1_chart_draw(content, idx);
            } else if(types[j] == 4) {
                sortable_table_draw(content,idx);
                set_table_format(idx,chartids[j],1);
            } else if(types[j] == 10) { //resonsive table
                responsive_table_draw(content,idx);
                set_table_format(idx,chartids[j],2);
            } else if(types[j] == 12){ // no table and chart
                noTableAndChartDraw(content,chartids[j] , idx,j);
            } else if(types[j] == 13){ // HORIZONTAL //////////////////////////////////////////////////
                horizontal_draw(content,chartids[j] , idx);
            } else if(types[j] == 14){ // stacked
                stacked_draw(content,chartids[j] , idx);
            } else if(types[j] == 15){ // vertical
                vertical_draw(content,chartids[j] , idx);
            } else if(types[j] == 16){ // line
                line_draw(content,chartids[j] , idx);
            } else if(types[j] == 17){ // point-styling
                point_styling_draw(content,chartids[j] , idx);
            } else if(types[j] == 18){ // bubble
                bubble_draw(content,chartids[j] , idx);
            } else if(types[j] == 19){ // combo-bar-line
                combo_bar_line_draw(content,chartids[j] , idx);
            } else if(types[j] == 20){ // doughnut
                doughnut_draw(content,chartids[j] , idx);
            } else if(types[j] == 21){ // multi-series-pie
                multi_series_pie_draw(content, chartids[j] ,idx);
            } else if(types[j] == 22){ // pie
                pie_draw(content,chartids[j] , idx);
            } else if(types[j] == 23){ // polar-area
                polar_area_draw(content, chartids[j] ,idx);
            } else if(types[j] == 24){ // radar
                radar_draw(content,chartids[j] , idx);
            } else if(types[j] == 25){ // scatter
                scatter_draw(content,chartids[j] , idx);
            } else if(types[j] == 26){ // area-radar
                area_radar_draw(content,chartids[j] , idx);
            } else if(types[j] == 27){ // line-stacked
                line_stacked_draw(content, idx);
            }
            // idx++;
        }
       
    }
    let contents = [];
    let helpArray = [];
    function getHelp(){
        @php
            $questionIds = $lesson->questions->pluck('id');
        @endphp
        let qustId = '{{$questionIds}}'; 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:"get",
            url:`{{route('user.get-help')}}`,
            data:{qustId:qustId},
            async: false,
            success: function (response) {
                var helpData = JSON.parse(response);
                var idx = 1;
                for(var i = 0; i < helpData.length; i++) {
                    let contents = [];
                    let value = helpData[i];
                    var helpInfoValue = value.content;
                    if(value.step == 2){
                        var chart_val = value.chartid;
                        var chart_type = value.type;
                        if (chart_type == 0) {
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div id="pie-chartdiv' + idx + '" ></div></div></p></div>');
                        } else if (chart_type === "1") {
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div id="donut-chartdiv' + idx + '" ></div></div></p></div>');
                        } else if (chart_type === "2") {
                            $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div id="bar-chartdiv' + idx + '" ></div></div></p></div>');
                        } else if (chart_type === "3") {
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div id="d3bar-chartdiv' + idx + '" ></div></div></p></div>');
                        } else if (chart_type == 5) {
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div id="horizontal-chartdiv' + idx + '" ></div></div></p></div>');
                        } else if (chart_type == 6) {
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div id="line-chartdiv' + idx + '" ></div></div></p></div>');
                        } else if (chart_type == 7) {
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div id="radar-chartdiv' + idx + '" ></div></div></p></div>');
                        } else if (chart_type == 8) {
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div id="polar-chartdiv' + idx + '" ></div></div></p></div>');
                        } else if (chart_type == 9) {
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div id="bubble-chartdiv' + idx + '" ></div></div></p></div>');
                        } else if (chart_type == 11) {
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div id="radar1-chartdiv' + idx + '" ></div></div></p></div>');
                        } else if (chart_type == 4) { //sortable table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div id="sortable_table' + idx + '" ><table class="table table-stried table-bordered table-sm" cellspacing="0" width="100%"></table></div></div></p></div>');
                        } else if (chart_type == 10) { //responsive table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div id="responsive_table' + idx + '" ></div></div></p></div>');
                        } else if (chart_tpe == 12) { //no chart and table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><span id="no_table_chart' + idx + '" class="col-12 no-table-chrt"></span></div></p></div>');
                        } else if (chart_type == 13) { //horizontal table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 14) { //stacked table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 15) { //vertical table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 16) { //line table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 17) { //point styling table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 18) { //bubble table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 19) { //combo-bar-line table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 20) { //doughnut table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 21) { //multi-series-pie table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 22) { //pie table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 23) { //polar-area table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 24) { //radar table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 25) { //scatter table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 26) { //area-radar table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        } else if (chart_type == 27) { //line-stacked table
                           $(".helpDiv").append('<div style="border: 1px solid black;padding: 5px;"><p><b><span style="font-size: 17px !important;font-weight: bold;">question n. '+value.qusno+' </span></b> </br><div style="word-wrap: break-word;"><div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div></div></p></div>');
                        }
                        var content = JSON.parse(value.content);
                        contents.push(ExpressionCalculation(content, value.question));
                        drawChart(contents,value.chartid,value.type,idx);
                    }else{
                        $(".helpDiv").append(helpInfoValue);
                    }
                    idx++;
                }
                setTimeout(function() {
                    // Your code here will run after a 5 second delay.
                    var fsize = "<?php echo $firstFontSize; ?>";
                    var fstyle = "<?php echo $firstStyle; ?>";
                    var fFamily = "<?php echo $firstFamily; ?>";

                    $('.setStyleDiv').css('font-size', ''+fsize+'');
                    $('.setStyleDiv').css('font-style', ''+fstyle+'');
                    $('.setStyleDiv').css('font-family', ''+fFamily+'');
                    
                }, 2000);
                
            },
            error: function (error) {
                var err = error.responseText;
                console.log(err);
            }
        })
    }

    function getHelpForModel(id){
        let qustId = '['+id+']'; 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:"get",
            url:`{{route('user.get-help-model')}}`,
            data:{qustId:qustId},
            async: false,
            success: function (response) {
                var helpData = JSON.parse(response);
                var idx = 1;
                for(var i = 0; i < helpData.length; i++) {
                    let contents = [];
                    let value = helpData[i];
                    var helpInfoValue = value.content;
                    if(value.step == 2){
                        var chart_val = value.chartid;
                        var chart_type = value.type;
                        if (chart_type == 0) {
                           $("#modelHelp").html('<div id="pie-chartdiv' + idx + '" ></div>');
                        } else if (chart_type === "1") {
                           $("#modelHelp").html('<div id="donut-chartdiv' + idx + '" ></div>');
                        } else if (chart_type === "2") {
                            $("#modelHelp").html('<div id="bar-chartdiv' + idx + '" ></div>');
                        } else if (chart_type === "3") {
                           $("#modelHelp").html('<div id="d3bar-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 5) {
                           $("#modelHelp").html('<div id="horizontal-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 6) {
                           $("#modelHelp").html('<div id="line-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 7) {
                           $("#modelHelp").html('<div id="radar-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 8) {
                           $("#modelHelp").html('<div id="polar-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 9) {
                           $("#modelHelp").html('<div id="bubble-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 11) {
                           $("#modelHelp").html('<div id="radar1-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 4) { //sortable table
                           $("#modelHelp").html('<div id="sortable_table' + idx + '" ><table class="table table-stried table-bordered table-sm" cellspacing="0" width="100%"></table></div>');
                        } else if (chart_type == 10) { //responsive table
                           $("#modelHelp").html(' <div id="responsive_table' + idx + '" ></div>');
                        } else if (chart_tpe == 12) { //no chart and table
                           $("#modelHelp").html(' <span id="no_table_chart' + idx + '" class="col-12 no-table-chrt"></span>');
                        } else if (chart_type == 13) { //horizontal table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 14) { //stacked table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 15) { //vertical table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 16) { //line table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 17) { //point styling table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 18) { //bubble table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 19) { //combo-bar-line table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 20) { //doughnut table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 21) { //multi-series-pie table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 22) { //pie table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 23) { //polar-area table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 24) { //radar table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 25) { //scatter table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 26) { //area-radar table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 27) { //line-stacked table
                           $("#modelHelp").html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        }
                        var content = JSON.parse(value.content);
                        contents.push(ExpressionCalculation(content, value.question));
                        drawChart(contents,value.chartid,value.type,idx);
                    }else{
                        var fsize = "<?php echo $firstFontSize; ?>";
                        var fstyle = "<?php echo $firstStyle; ?>";
                        var fFamily = "<?php echo $firstFamily; ?>";
                        $("#modelHelp").html(helpInfoValue);
                        // $(".modelTextStyle").css('font-size','20');
                        $('.modelTextStyle').css('font-size', ''+fsize+'');
                        $('.modelTextStyle').css('font-style', ''+fstyle+'');
                        $('.modelTextStyle').css('font-family', ''+fFamily+'');
                    }
                    idx++;
                }
                
            },
            error: function (error) {
                var err = error.responseText;
                console.log(err);
            }
        })
    }

    function getQustionGraph(id){
        let qustId = '['+id+']'; 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:"get",
            url:`{{route('user.get-graph')}}`,
            data:{qustId:qustId},
            async: false,
            success: function (response) {
                var helpData = JSON.parse(response);
                var idx = 1;
                for(var i = 0; i < helpData.length; i++) {
                    let contents = [];
                    let value = helpData[i];
                    var helpInfoValue = value.content;
                    if(value.step == 2){
                        var chart_val = value.chartid;
                        var chart_type = value.type;
                        if (chart_type == 0) {
                           $("#dynamic_chart"+id).html('<div id="pie-chartdiv' + idx + '" ></div>');
                        } else if (chart_type === "1") {
                           $("#dynamic_chart"+id).html('<div id="donut-chartdiv' + idx + '" ></div>');
                        } else if (chart_type === "2") {
                            $("#dynamic_chart"+id).html('<div id="bar-chartdiv' + idx + '" ></div>');
                        } else if (chart_type === "3") {
                           $("#dynamic_chart"+id).html('<div id="d3bar-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 5) {
                           $("#dynamic_chart"+id).html('<div id="horizontal-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 6) {
                           $("#dynamic_chart"+id).html('<div id="line-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 7) {
                           $("#dynamic_chart"+id).html('<div id="radar-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 8) {
                           $("#dynamic_chart"+id).html('<div id="polar-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 9) {
                           $("#dynamic_chart"+id).html('<div id="bubble-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 11) {
                           $("#dynamic_chart"+id).html('<div id="radar1-chartdiv' + idx + '" ></div>');
                        } else if (chart_type == 4) { //sortable table
                           $("#dynamic_chart"+id).html('<div id="sortable_table' + idx + '" ><table class="table table-stried table-bordered table-sm" cellspacing="0" width="100%"></table></div>');
                        } else if (chart_type == 10) { //responsive table
                           $("#dynamic_chart"+id).html(' <div id="responsive_table' + idx + '" ></div>');
                        } else if (chart_tpe == 12) { //no chart and table
                           $("#dynamic_chart"+id).html(' <span id="no_table_chart' + idx + '" class="col-12 no-table-chrt"></span>');
                        } else if (chart_type == 13) { //horizontal table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 14) { //stacked table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 15) { //vertical table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 16) { //line table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 17) { //point styling table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 18) { //bubble table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 19) { //combo-bar-line table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 20) { //doughnut table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 21) { //multi-series-pie table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 22) { //pie table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 23) { //polar-area table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 24) { //radar table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 25) { //scatter table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 26) { //area-radar table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        } else if (chart_type == 27) { //line-stacked table
                           $("#dynamic_chart"+id).html(' <div class="col-12 chartcontainer"><canvas id="myChart"></canvas></div>');
                        }
                        var content = JSON.parse(value.content);
                        contents.push(ExpressionCalculation(content, value.question));
                        drawChart(contents,value.chartid,value.type,idx);
                    }else{
                        $("#dynamic_chart"+id).html(helpInfoValue);
                    }
                    idx++;
                }
                
            },
            error: function (error) {
                var err = error.responseText;
                console.log(err);
            }
        })
    }


    function convertNumberFormat(inputValue) {
        var replacedValue = inputValue.replace(/,/g, '#'); // Replace all commas with a temporary character '#'
        replacedValue = replacedValue.replace(/\./g, ','); // Replace all periods with commas
        replacedValue = replacedValue.replace(/#/g, ','); // Replace all temporary characters '#' with periods

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

