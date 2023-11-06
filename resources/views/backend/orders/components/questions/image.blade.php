@if(!empty($content))
<style>
    .change-img-bg-color{
        background: rgba(20,6,62,1);
    }
</style>
<div class="row image_content">
    @if(isset($content) && !empty($content[0]->image))
        @foreach($content[0]->image as $key=>$c)
        <div class="{{isset($content[(sizeof($content)-1)]->col)?$content[(sizeof($content)-1)]->col:''}} mt-2">
            <img id="preview" src="" width="100%">
                <div class="form-group">
                    <img src="{{asset('uploads/image/')}}{{'/'.$c}}" class="img-thumbnail" alt="image{{$key}}" onclick="clickimg(this)" srcset="">
                    <input class="form-check-input {{' imagebox_'.$key}}" type="radio" style="display:none" name="imgradiogroup"  id="{{$question->id}}" data-key="{{$key+1}}" value="{{$content[0]->score[$key]}}" data-score="{{$content[0]->score[$key]}}">
                </div>
        </div> 
        @endforeach
    @endif
</div>
@endif
@push('after-scripts')
    <script>
        function clickimg(ele){
            if($('#percent').val() == 1000  && $('#reported').val() == 10){
                alert('You can not edit your answers!');
            }else {
                $('.change-img-bg-color').each(function(){
                    $(this).removeClass('change-img-bg-color');
                });
                $(ele).addClass('change-img-bg-color');
                $(ele).next().prop("checked", true);
            }
        }
    </script>
@endpush