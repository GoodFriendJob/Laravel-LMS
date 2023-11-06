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

            
            
        @endphp
        <div class="row check_content">
        @if ($content !== null)
            @foreach($content as $key => $c)
                @if(isset($c->label))
                <div class="{{$col}}">
                    <div class="form-check">
                        <div class="square-check gradient-bg" >
                            <script>$("body").append(`<style>.toggle_btn_active{background:<?php echo $question->color2 == NULL ? $lesson->color2 : $question->color2?> !important;<?php 
                                echo str_replace(";"," !important;",$fontstyle1) ?>}.square-check.gradient-bg{background:gray;<?php echo $fontstyle2 ?>}</style>`)</script>
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