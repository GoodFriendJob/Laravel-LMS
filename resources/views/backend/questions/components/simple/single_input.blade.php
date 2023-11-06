{{-- Single Input --}}
@php

    $value = $width = $height = '';
    if(isset($question)){
    $cont=$question->content;
    $obj = json_decode($cont,true);

    isset($obj[0]["value"]) ? $value = $obj[0]["value"] : '';
    isset($obj[0]["width"]) ? $width = $obj[0]["width"] : '';
    isset($obj[0]["height"]) ? $height = $obj[0]["height"] : '';
}   
@endphp
<div id="single_input_part" class="question-box" @if(isset($display)) style="display:{{$display}};" @endif>
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
    <div class="form-group">
        <input type="text" id="single_input_value" class="form-control " placeholder="Text" value='{{$value}}'>
    </div>
    <div class="form-group">
        <input type="text" id="single_input_width" class="form-control " placeholder="Width" value='{{$width}}'>
    </div>
    <div class="form-group">
        <input type="text" id="single_input_height" class="form-control " placeholder="Height" value='{{$height}}'>
    </div>
</div>
{{-- End Signle Input --}}