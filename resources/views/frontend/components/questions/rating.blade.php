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
<div class='rating-box rating_content'  data-required="@if($question->required=="1") 1 @else 0 @endif" >
    <ul id='rating-list{{ $question->id }}'>
        <div class="row">
            @php
                $i=1;
                $color = $lesson->color1;
                if (is_array($content)) {
                foreach($content as $c){
                    if(isset($c->col)) $col = $c->col;
                }
            }
            @endphp
            @if($content != '')

                @foreach($content as $c)
                    @if(isset($c->label))
                        <div class="{{isset($col)?$col:''}} mt-1">
                            <li class='rate' id='rate{{$i}}' onclick='changeRating({{$i}})' data-q_id="{{$question->id}}" name="rating" style="color:<?php if($lesson->color2 != ""){ echo $lesson->color2;  }else{ echo "black";}  ?>;font-size:{{$firstFontSize}};font-style:{{$firstStyle}};font-family:{{$firstFamily}};" title="{{$c->score}}" data-value='{{$i}}' data-score="{{$c->score}}">
                                {{$c->label}}
                            </li>
                        </div>
                    @elseif(isset($c->color))
                        @php
                            $color = $lesson->color1;
                        @endphp
                    @endif
                    @php
                        $i++;
                    @endphp
                @endforeach
            @endif
        </div>
        
    </ul>
    <input type="hidden" name="star_color" class="star_color" value="{{$color}}">
    <input type="hidden" class="ratinginput" name="b_rating" id="scoreNow{{ $question->id }}" data-qid="{{ $question->id }}" value="0" data-selected="false">
    <span class="message mt-2"></span>
</div>
<script>
function changeRating(boxid){
    var text1 = "<?php echo $firstFontSize1 ?>";
    var text2 = "<?php echo $firstFontSize ?>";
    $(".rate").css('font-size',''+text2+'');
    $("#rate"+boxid).css('font-size',''+text1+'');
}


</script>