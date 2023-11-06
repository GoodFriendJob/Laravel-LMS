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
<div class="mb-2 dropdowninput" data-required="@if($question->required=="1") 1 @else 0 @endif">

    <div class="form-group">
        <label for="">Select Value</label>
        <select class="form-control dropdown" name="dropdown"  id="{{$question->id}}" style='height: auto !important;border-color:{{$lesson->color1}};font-size:{{$firstFontSize}};font-style:{{$firstStyle}};font-family:{{$firstFamily}};'>
        
          <option value="">Select Option</option>
          
            @if(isset($content) && (is_array($content) || $content instanceof Countable))
                @foreach($content as $key => $c)
                    @if($key != (sizeof($content) - 1))
                        @if(isset($c->label))
                            <option id="opt" data-key="{{ $key + 1 }}" value="{{ $c->score }}">{{ $c->label }}</option>
                        @endif
                    @endif
                @endforeach
           @endif

        </select>
  </div>
  <span class="message mt-2"></span>
</div>
<script>
  $("body").append(`<style>#q_<?php echo $question->id ?> label{<?php echo $fontstyle2 ?>}</style>`)
</script>
