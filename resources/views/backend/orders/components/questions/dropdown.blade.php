<div class="mb-2 dropdowninput" data-required="@if($question->required=="1") 1 @else 0 @endif">

    <div class="form-group">
        <label for="">Select Value</label>
        <select class="form-control dropdown" name="dropdown"  id="{{$question->id}}">
        
          <option value="">Select Option</option>
          
            @foreach($content as $key=>$c)
              @if($key != (sizeof($content)-1))
                @if(isset($c->label))
                    <option id="opt" data-key="{{$key+1}}" value="{{$c->score}}">{{$c->label}}</option>
                @endif
              @endif
            @endforeach
        </select>
  </div>
  <span class="message mt-2"></span>
</div>
<script>
  $("body").append(`<style>#q_<?php echo $question->id ?> label{<?php echo $fontstyle2 ?>}</style>`)
</script>