<div class='rating-box rating_content'  data-required="@if($question->required=="1") 1 @else 0 @endif" >
    <ul id='rating-list{{ $question->id }}'>
        <div class="row">
            @php
                $i=1;
                $color = "#fcb103";
                foreach($content as $c){
                    if(isset($c->col)) $col = $c->col;
                }
            @endphp
            @if($content != '')

                @foreach($content as $c)
                    @if(isset($c->label))
                        <div class="{{isset($col)?$col:''}} mt-1">
                            <li class='rate rate-{{$i}}' data-q_id="{{$question->id}}" name="rating" title="{{$c->score}}" data-value='{{$i}}' data-score="{{$c->score}}">
                                {{$c->label}}
                            </li>
                        </div>
                    @elseif(isset($c->color))
                        @php
                            $color = $c->color;
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
