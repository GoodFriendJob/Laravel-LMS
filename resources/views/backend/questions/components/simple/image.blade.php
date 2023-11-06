{{-- Image --}}
@php
    $image_count = 2;
    if(isset($question->content) && $question->content != null){
        $content = json_decode($question->content);
        if(is_array($content)){
            $col = isset($content[(sizeof($content))-1]->col)?$content[(sizeof($content))-1]->col:'';
        }
        else{
            $col = '';
        }
        
    }
@endphp
<div id="image_part" class="row question-box" @if(isset($display)) style="display:{{$display}};" @endif>
    <?php
        if(isset($question)) 
        {
            echo Form::label('color1',trans('labels.backend.tests.fields.color1'), ['class' => 'control-label']);
            echo Form::color('color1', $question->color1 ? $question->color1 : $current_tests[0]->color1, ['class' => 'form-control ', 'name'=>'color1']);
            echo Form::label('color2',trans('labels.backend.tests.fields.color2'), ['class' => 'control-label']);
            echo Form::color('color2', $question->color2 ? $question->color2 : $current_tests[0]->color2, ['class' => 'form-control ', 'name'=>'color2']);
        }
        else {
            echo Form::label('color1',trans('labels.backend.tests.fields.color1'), ['class' => 'control-label']);
            echo Form::color('color1', '', ['class' => 'form-control ', 'name'=>'color1']);
            echo Form::label('color2',trans('labels.backend.tests.fields.color2'), ['class' => 'control-label']);
            echo Form::color('color2', '', ['class' => 'form-control ', 'name'=>'color2']);
        }
    ?>
    <div class="col-12">
        <label for="">Select Display</label>
        @if(isset($content))
           @php
               $con = $content;
               foreach($con as $key => $c){
                   if(isset($c->display)){
                       $display = $c->display;
                   }
               }
           @endphp
       @endif
        @php $disp_len = 4; $max = 12; @endphp
        <select name="display_image" class="form-control" id="display_image">
            @for($i = 1; $i <= $disp_len; $i++)
               <option value="{{'col-'.$max/$i}}" @if(isset($display))@if($i == $display) selected @endif @endif>{{$i}}</option>
            @endfor
        </select>
    </div>
    <div class="col-md-12 form-body">                                    
        <div class="form-group ">
            <!-- <label class="control-label col-md-3">Image Upload</label> -->
            <div class="col-md-12">
                <form method="POST" enctype="multipart/form-data" class="image-upload-form" action="javascript:void(0)" id="sortable-13">
                    @csrf
                    <div class="form-group " id="sortable-11">
                        <div class="input-group hdtuto control-group lst increment image_part_file" style="margin-right:30%">
                            {{-- <input type="file" name="file[]" class="b-images myfrm form-control images" value=""> --}}
                            {{-- <input  class="imge_names" type="hidden"  value=""> --}}
                            <div class="input-group-btn"> 
                                <button class="btn btn-success add-btn" type="button">+</button>
                            </div>
                            {{-- <label  style="margin-left:5vw;margin-right:1vw;">Score</label> --}}
                            {{-- <input  class="image_score" type="text"   value="" style="margin-right:1vw"> --}}
                        </div>
                            @if(isset($content) && !empty($content[0]->image))
                                @foreach($content[0]->image as $key=>$c)
                                    <div class="image_part_file" >
                                        <div class="hdtuto control-group lst input-group" style="margin-top:10px">
                                            <input type="file" name="file[]" class="b-images images myfrm form-control">
                                            <input  class="imge_names" type="hidden" value="{{$c}}">
                                            <div class="input-group-btn">
                                                <button class="btn btn-danger del-btn" type="button"><i class="fa fa-trash" style="color:white"></i></button>
                                            </div>
                                            <label style="margin-left:5vw;margin-right:1vw;">Score</label>
                                            <input class="image_score" type="text" value="{{$content[0]->score[$key]}}" style="margin-right:1vw">
                                            <img src="{{'/uploads/image/'.$c}}"  width="50px" height="50px" style="object-fit:fill">
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="image_part_file">
                                    <div class="hdtuto control-group lst input-group" style="margin-top:10px">
                                        <input type="file" name="file[]" class="b-images images myfrm form-control q">
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger del-btn" type="button"><i class="fa fa-trash" style="color:white"></i></button>
                                        </div>
                                        <label style="margin-left:5vw;margin-right:1vw;">Score</label>
                                        <input class="image_score" type="text" value="" style="margin-right:1vw">                             </div>
                                </div>
                            @endif
                    </div>
                    
                    <div class="clone-sample" style="display: none;">
                        <div class="image_part_file">
                            <div class="hdtuto control-group lst input-group" style="margin-top:10px;padding-right:8%;">
                                <input type="file" name="file[]" class="b-images images myfrm form-control q">
                                <input  class="imge_names" type="hidden" value="">
                                <div class="input-group-btn"> 
                                <button class="btn btn-danger del-btn" type="button"><i class="fa fa-trash" style="color:white"></i></button>
                                </div>
                                <label  style="margin-left:5vw;margin-right:1vw;">Score</label>
                                <input  class="image_score" type="text"   value="" style="margin-right:1vw">
                            </div>                                  
                        </div>
                    </div>
            
                {{-- <button type="submit" class="btn btn-success" style="margin-top:10px">Submit</button>     --}}
                </form>
            </div>
        </div>            
    </div>
</div>   
{{-- End Image --}}