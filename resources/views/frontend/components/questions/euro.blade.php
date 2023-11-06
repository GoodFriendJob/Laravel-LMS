@php
    if(isset($content)){
        $content = json_decode($question->content);
    }
    $width = $height = '';
    isset($content[0]->width) ? $width = $content[0]->width : '';
    isset($content[0]->height) ? $height = $content[0]->height : '';
@endphp
<?php

if(isset($firstFontSize)){
    $firstFontSize = $firstFontSize;
}else{
    $firstFontSize = '';
}

if(isset($firstStyle)){
    $firstStyle = $firstStyle;
}else{
    $firstStyle = '';
}

if(isset($firstFamily)){
    $firstFamily = $firstFamily;
}else{
    $firstFamily = '';
}

if(isset($firstFontSize1)){
    $firstFontSize1 = $firstFontSize1;
}else{
    $firstFontSize1 = '';
}

if(isset($firstStyle1)){
    $firstStyle1 = $firstStyle1;
}else{
    $firstStyle1 = '';
}

if(isset($firstFamily1)){
    $firstFamily1 = $firstFamily1;
}else{
    $firstFamily1 = '';
}

?>
<div class="euroinput">
  <div class="row">
    <div class="col">
      <div class="input-group">
        <span class="input-group-addon" style="color:{{$question->color2 == NULL ? 'black' : $question->color2}}; text-align: center !important; background-color: {{$question->color1 == NULL ? $lesson->color1 : $question->color1}};font-size:{{$firstFontSize}};font-style:{{$firstStyle}};font-family:{{$firstFamily}};">
          €
        </span>
        <input type="text" name="number" onchange='formatEuro({{$question->id}})' class="form-control euroNum" value="" id="{{$question->id}}" @if($question->required) required @endif style="width:{{$width}}px;height:{{$height}}px; border-color:{{$lesson->color1}};{{$fontstyle2}}">
      </div>
    </div>
  </div>
</div>

<script>
function formatEuro(id) {
    var n = $("#"+id).val();
    var euroThousen = parseFloat(n, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
    // alert(euroThousen);
    $(".euroNum").val(euroThousen);
}

</script>