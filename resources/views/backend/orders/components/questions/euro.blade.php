@php
    if(isset($content)){
        $content = json_decode($question->content);
    }
    $width = $height = '';
    isset($content[0]->width) ? $width = $content[0]->width : '';
    isset($content[0]->height) ? $height = $content[0]->height : '';
@endphp
<div class="euroinput">
  <div class="row">
    <div class="col">
      <div class="input-group">
        <span class="input-group-addon" style="background-color: {{$question->color1 == NULL ? $lesson->color1 : $question->color1}};text-align:center;<?php echo $fontstyle2?>">
          €
        </span>
        <input type="number" name="number" class="form-control" value="4.99" id="{{$question->id}}" @if($question->required) required @endif style="width:{{$width}}px;height:{{$height}}px ">
      </div>
    </div>
  </div>
</div>