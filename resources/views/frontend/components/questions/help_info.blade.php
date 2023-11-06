{{-- Help Info --}}
    @if($question->help_info != '')
        <p data-toggle="modal" data-target="#exampleModalLong{{$question->id}}">
            <img src="{{asset('/storage/logos/help.png')}}" class="img-responsive">
        </p>
        <div class="modal fade" id="exampleModalLong{{$question->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content bg-white">
                    <div class="modal-header backgroud-style p-0">
                        <div class="gradient-bg"></div>

                        <div class="popup-logo">
                            <img src="{{asset('storage/logos/popup-logo.png')}}" alt="">
                        </div>

                        <div class="popup-text text-center p-2">
                            <h2 class="mt-5">Guida</h2>
                        </div>

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        {!!$question->help_info!!}
                        <div class="nws-button text-right white text-capitalize">
                            <button type="button"  style="height:unset;width:unset;font-size:1.2rem;" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
{{-- End Help Info --}}
<script>
    $("body").append(`<style>#q_<?php echo $question->id ?> .modal-body p{<?php echo $fontstyle2;?>}</style>`)
</script>