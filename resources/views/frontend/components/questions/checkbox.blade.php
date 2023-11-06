<div class="mb-2">
    <div class="checkbox-input" data-required="@if($question->required=="1") 1 @else 0 @endif">
        @php
            $temp_val =1;
            $content = json_decode($question->content);

if ($content !== null) {
    foreach ($content as $key => $c) {
        if (isset($c->col)) {
            $col = $c->col;
        }
    }
}
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
            
        @endphp
        <div class="row check_content">
        @if ($content !== null)
            @foreach($content as $key => $c)
                @if(isset($c->label))
                <div class="{{$col}}">
                    <div class="form-check">
                        <div class="square-check gradient-bg" style='color: black !important;' >
                            <script>$("body").append(`<style>.toggle_btn_active{background:<?php echo $question->color1 == NULL ? $lesson->color1 : $question->color1?> !important;color:black;<?php 
                                echo str_replace(";"," !important;",$fontstyle1) ?>}.square-check.gradient-bg{background:{{$question->color2}};<?php echo 'font-size:'.  $firstFontSize.';font-style:'.$firstStyle.';font-family:'.$firstFamily.';' ?>}</style>`)</script>
                            <input class="form-check-input {{' checkbox_'.$key}}" name="checkbox-radio" type="radio" data-qid="{{$question->id}}" data-key="{{$key+1}}" value="{{$c->score}}" {{(isset($identy[$question->id]))?($identy[$question->id]==$c->score)?'data-opendiv='.$ids[$question->id]:'':''}} name="flexRadioDefault"  id="{{$question->id}}">
                            {{$c->label}}
                            <div class="square-check--content"></div>
                        </div>
                    </div>
                </div>
                @endif
                @php
                    $temp_val++;
                @endphp
            @endforeach
            @endif
        </div>
    </div>
    <span class="message mt-2"></span>
</div>