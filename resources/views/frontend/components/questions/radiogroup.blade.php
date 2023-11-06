
<style>

input[type='radio']:not(:checked) {
    border-color: red !important; /* change this to the color you want */
}
</style>
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
?>
<div class="mb-2 radiogroup" data-required="@if($question->required=="1") 1 @else 0 @endif">
 
  @if($content != '')
  <div class="row radio_content">
    @php
      foreach($content as $key => $c){
        if(isset($c->col)) $col = $c->col;
        if(isset($c->display)) $display = $c->display;
      }
    @endphp
    @foreach($content as $key=>$c)
      @if(isset($c->label))
      <div class="{{$col}}">
        <div class="form-check form-check-inline">
          <input class="form-check-input {{' radio_'.$key}}" type="radio" name="radiogroup" id="{{$question->id}}" data-key="{{$key+1}}" value="{{$c->score}}" data-score="{{$c->score}}">
          <label class="form-check-label" for="inlineRadio1">{{$c->label}}</label>
        </div>
      </div>
      @endif
    @endforeach
  </div>
    <div class="message mt-2">
    </div>
  @endif
</div>
<script>
  $("#q_<?php echo $question->id ?> input[type='radio']").css("accent-color", `<?php echo $question->color1 == NULL ? $lesson->color1 : $question->color1 ?>`);
  $("body").append(`<style>#q_<?php echo $question->id ?> label{<?php echo 'font-size:'.$firstFontSize.';font-style:'.$firstStyle.';font-family:'.$firstFamily.';' ?>}</style>`);
</script>