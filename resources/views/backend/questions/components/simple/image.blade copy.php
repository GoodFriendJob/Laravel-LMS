{{-- Image --}}
@php
    $image_count = 2;
    if(isset($question->content)){
        $content = json_decode($question->content);
        $col = $content[(sizeof($content))-1]->col;
    }
@endphp
<div id="image_part" class="row question-box" @if(isset($display)) style="display:{{$display}};" @endif>
    <?php
        if(isset($question)) 
        {
            echo Form::label('color1',trans('labels.backend.tests.fields.color1'), ['class' => 'control-label']);
            echo Form::color('color1', $question->color1 ? $question->color1 : $current_tests[0]->color1, ['class' => 'form-control ', 'name'=>'color1']);
            echo Form::label('color2',trans('labels.backend.tests.fields.color2'), ['class' => 'control-label']);
            echo Form::color('color2', $question->color2 ? $question->color2 : $current_tests[0]->color2, ['class' => 'form-control ', 'name'=>'color2']);
        }
        else {
            echo Form::label('color1',trans('labels.backend.tests.fields.color1'), ['class' => 'control-label']);
            echo Form::color('color1', '', ['class' => 'form-control ', 'name'=>'color1']);
            echo Form::label('color2',trans('labels.backend.tests.fields.color2'), ['class' => 'control-label']);
            echo Form::color('color2', '', ['class' => 'form-control ', 'name'=>'color2']);
        }
    ?>
    <div class="col-12">
        <label for="">Select Display</label>
        <select name="image_file_display" class="form-control" id="image_file_display">
            <option value="col-12" {{isset($content)?($col == 'col-12')?'selected':'':''}}>1</option>
            <option value="col-6" {{isset($content)?($col == 'col-6')?'selected':'':''}}>2</option>
            <option value="col-3" {{isset($content)?($col == 'col-3')?'selected':'':''}}>3</option>
            <option value="col-4" {{isset($content)?($col == 'col-4')?'selected':'':''}}>4</option>
        </select>
    </div>
    <div class="col-md-12 form-body">                                    
        <div class="form-group ">
            <!-- <label class="control-label col-md-3">Image Upload</label> -->
            <div class="col-md-9">
                <form method="POST" enctype="multipart/form-data" class="image-upload-form" action="javascript:void(0)" id="sortable-13">
                    @csrf
                    <div class="form-group " id="sortable-11">
                        <div class="input-group hdtuto control-group lst increment image_part_file" >
                            <form id="question_type_image" class="images_files" action="" method="POST" enctype="multipart/form-data">
                            @csrf
                                <input type="file" name="file[]" class="myfrm form-control "  data-q_id="{{$last_q_id}}0" value="">
                                <input type="hidden" name="images" class="images_user{{$last_q_id}}0" data-id="{{$last_q_id}}0" id="{{$last_q_id}}0" value="">
                                <input type="hidden" id="img_q_id" name="user_upload_img" value="{{$last_q_id}}0">
                                <input type="hidden" id="add_img_q_id" name="user_upload_img" value="{{$last_q_id}}1">
                                <div class="input-group-btn"> 
                                    <button class="btn btn-success add-btn" type="button">+</button>
                                </div>
                                <label  style="margin-left:5vw;margin-right:1vw;">Score</label>
                                <input  class="image_score" type="text"   value="" style="margin-right:1vw">
                            </form>
                        </div>
                        <div class="clone">
                            @if(isset($content))
                                @foreach($content as $key=>$c)
                                    @if($key < (sizeof($content)-1))
                                        <div class="image_part_file" >
                                            <div class="hdtuto control-group lst input-group" style="margin-top:10px">
                                                <input type="file" name="file" class="images myfrm form-control">
                                                <div class="input-group-btn"> 
                                                <button class="btn btn-danger del-btn" type="button"><i class="fa fa-trash" style="color:white"></i></button>
                                                </div>
                                                <label  style="margin-left:5vw;margin-right:1vw;">Score</label>
                                                <input  class="image_score" type="text"   value="{{$c->score}}" style="margin-right:1vw">
                                            </div>                                    
                                        </div>
                                    @endif
                                @endforeach
                            @else
                            <div class="image_part_file" >
                            <form id="question_type_image" class="images_files" action="" method="POST" enctype="multipart/form-data">
                                    @csrf
                                <div class="hdtuto control-group lst input-group" style="margin-top:10px">
                                  
                                    <input type="file" name="file[]" class="images myfrm form-control q" data-q_id="{{$last_q_id}}1" value="">
                                    <input type="hidden" name="images" class="images_user{{$last_q_id}}1" data-id="{{$last_q_id}}1" id="{{$last_q_id}}1" value="">
                                    <input type="hidden" id="img_q_id" name="user_upload_img" value="{{$last_q_id}}1">
                                    <div class="input-group-btn"> 
                                    <button class="btn btn-danger del-btn" type="button"><i class="fa fa-trash" style="color:white"></i></button>
                                    </div>
                                    <label  style="margin-left:5vw;margin-right:1vw;">Score</label>
                                    <input  class="image_score" type="text"   value="" style="margin-right:1vw">
                               
                                </div>  
                                </form>                                  
                            </div>
                            @endif
                        </div>
                    </div>
                    
            
                {{-- <button type="submit" class="btn btn-success" style="margin-top:10px">Submit</button>     --}}
                </form>
            </div>
        </div>            
    </div>
</div>   
{{-- End Image --}}  
@push('after-scripts')
    <script>
        // Add images
    $(".question_images").on('change', function(e) {
        alert("here");
        e.preventDefault();
            var data = new FormData();
            data.append('file', $('.question_images')[0].files[0]);
            data.append('q_id',$(this).data('q_id'));
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: `{{route('user_upload_images')}}`,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                swal('success','Image uploaded to the server.','success');
                $("#user_upload_img").val(response.img_name);
                $(".images_user"+response.q_id).val(response.img_name);
            },
            error: function(response) {
                swal('error','Error in uploading the image.','error');
                console.log(response);
            }
        })
    });
    </script>
@endpush