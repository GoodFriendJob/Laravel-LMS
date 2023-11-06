@extends('backend.layouts.app')
@section('title', __('labels.backend.questions.title').' | '.app_name())

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">Quetion_{{$question->id}}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('labels.backend.questions.fields.question')</th>
                            <td>{!! $question->question !!}</td>
                        </tr>
                        <tr>
                            <th>Question Type</th>
                            <td>
                                @if($question->questiontype == 0)
                                    <p>Single Input</p>
                                @elseif($question->questiontype == 1)
                                    <p>CheckBox</p>
                                @elseif($question->questiontype == 2)
                                    <p>RadioGroup</p>
                                @elseif($question->questiontype == 3)
                                    <p>Image Selection</p>
                                @elseif($question->questiontype == 4)
                                    <p>Matrix</p>
                                @endif
                            </td>
                        </tr>
                     
                    </table>
                </div>
            </div><!-- Nav tabs -->

            
            <?php
                $content= json_decode($question->content);              
            ?>
            @if ($question->questiontype ==0)
                  
                    <div class="row main-content" id="single_input_part" >
                        <div class="col-8 form-group">
                        <label  class="control-label">Single Input</label>
                        <input type="textarea" class="form-control" rows="2" value="{{$content}}">
                    
                        </div>
                        <div class="col-4">
                            <div class="form-body">                                    
                                <div class="form-group ">
                                    <img  src="/uploads/image/{{$question->questionimage}}"
                                    alt="single ptext part" style="max-height: 150px;">
                                </div>
                
                            </div>
                        </div>
                    </div>
            
            @elseif ($question->questiontype ==1)             
          
            <div class="row main-content" style="borde:1px solid #00ff00;" id="checkbox_part">
          
                <div id="sortable-10" class="col-7 form-group" style="margin-left:20px">
                    @for($i = 0;$i< count($content); $i++)    
                        <div  class="checkbox">
                            <label><input type="checkbox" >{{$content[$i]}}</label>                      
                        </div>
                    @endfor
                    
                </div>
                
                <div class="col-4">
                    <div class="form-body">                                    
                        <div class="form-group ">
                            <img  src="/uploads/image/{{$question->questionimage}}"
                            alt="checkbox part" style="max-height: 150px;">
                        </div>
        
                    </div>
                </div>
            </div>
            @elseif ($question->questiontype ==2)    
 
            <div class="row" style="borde:1px solid #00ff00;" id="radio_part">
               
                <div class="col-7  form-group " id="sortable-11" style="margin-left:20px">
                    @for($i = 0;$i< count($content); $i++)      
                    <div class="radio">
                        <label ><input type="radio" name="optradio" >{{$content[$i]}}</label>
                    </div>                    
                    @endfor
                </div>
                <div class="col-4">
                    <div class="form-body">                                    
                        <div class="form-group ">
                            <img src="/uploads/image/{{$question->questionimage}}"
                            alt="radiopart" style="max-height: 150px;">
                        </div>
        
                    </div>
                </div>
            </div>   
            @elseif ($question->questiontype ==3)       
            <div class="row">
                
                    @for($num= 0; $num< count($content); $num++)  
                        <div class="col-3 image_box" style="padding-left:30px;width:7vw;height:10vw;" display="inline-flex" >
                            <div  class="checkbox">
                                <input type="checkbox">                      
                            </div>
                            <img src="/uploads/image/{{ $content[$num] }}"  width="100px" height="100px" style="max-width:100%; max-height:100%; object-fit:fill">
                        </div>
                    @endfor    
                <
            </div>

            @elseif ($question->questiontype ==4)
                <div class="row">
                    <div class="col-12" style="padding-top:3vh;">
                        <table  id="real_matrix" width="100%">
                        @for($i=0;$i< count($content); $i++)
                            <tr>
                            @for($j=0;$j< count($content[1]); $j++)
                                <td><input type="text" placeholder="" class="form-control" value="{{$content[$i][$j]}}"></td>

                            @endfor
                            </tr>
                        @endfor
                        </table>                        
                    </div> 
                </div>
               
            @endif
         

            <a href="{{ route('admin.questions.index') }}"
               class="btn btn-default border mt-3">@lang('strings.backend.general.app_back_to_list')</a>
        </div>
    </div>

    <script>
     
    </script>
@stop