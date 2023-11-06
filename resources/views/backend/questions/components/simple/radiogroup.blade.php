{{-- Radio Group --}}
<div id="radiogroup" class="row question-box" @if(isset($display)) style="display:{{$display}};" @endif>
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
        <a id="radio_add" href="javascript:void(0);" class="btn btn-success">+ New</a>
    </div>
    <div class="col-12">
        <label for="">Select Display</label>
        @if(isset($content))
           @php
               $con = json_decode($content);
               foreach($con as $key => $c){
                   if(isset($c->display)){
                       $display = $c->display;
                   }
               }
           @endphp
       @endif
        @php $disp_len = 4; $min = 3; @endphp
        <select name="display_radiogroup" class="form-control" id="display_radiogroup">
            @for($i = 1; $i <= $disp_len; $i++)
               <option value="{{'col-'.$min*$i}}" @if(isset($display))@if($i == $display) selected @endif @endif>{{$i}}</option>
            @endfor
        </select>
    </div>
    <div class="col-12  form-group " id="sortable-11">
    <!-- <form> --> 
    @if(isset($content) && $content !=  '')
        @php
            $radioContent = json_decode($content);  
        @endphp

        @foreach($radioContent as $key=>$c)
            @if(isset($c->label))
            <div class="radio">
                <label  style="color:transparent"><input type="radio" name="opt_radiogroup" @if(isset($c->is_checked)){{($c->is_checked==1) ? 'checked' : '' }}@endif>Option 1</label>
                <input class="radio_label" type="text" value="{{$c->label}}" style="margin-left:-2vw;;margin-right:5vw;z-index:20;border:none;">
                <label  >Score</label>
                <input  class ="radio_score" type="text"   value="{{$c->score}}" style="margin-right:1vw">
                <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="41">
                    <i class="fa fa-trash" style="color:white"></i>
                </a>
            </div>
            @endif
        @endforeach
    @else
        <div class="radio">
            <label  style="color:transparent"><input type="radio" name="optradio" checked>Option 1</label>
            <input class="radio_label" type="text" value="radio1" style="margin-left:-2vw;;margin-right:5vw;z-index:20;border:none;">
            <label  >Score</label>
            <input  class ="radio_score" type="text"   value="" style="margin-right:1vw">
            <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="41">
                <i class="fa fa-trash" style="color:white"></i>
            </a>
        </div>
        <div class="radio">
            <label  style="color:transparent"><input type="radio" name="optradio" >Option 2</label>
            <input class="radio_label" type="text" value="radio1" style="margin-left:-2vw;;margin-right:5vw;z-index:20;border:none;">
            <label  >Score</label>
            <input  class ="radio_score" type="text"   value="" style="margin-right:1vw">
            <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="42">
                <i class="fa fa-trash" style="color:white"></i>
            </a>
        </div>
        <div class="radio">
            <label  style="color:transparent"><input type="radio" name="optradio" >Option 2</label>
            <input class="radio_label" type="text" value="radio1" style="margin-left:-2vw;;margin-right:5vw;z-index:20;border:none;">
            <label  >Score</label>
            <input   class ="radio_score"  type="text"   value="" style="margin-right:1vw">
            <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="43">
                <i class="fa fa-trash" style="color:white"></i>
            </a>
        </div>
    @endif
    </div>
</div>
{{-- End Radio Group --}}