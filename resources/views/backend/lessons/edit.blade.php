@extends('backend.layouts.app')
@section('title', __('labels.backend.lessons.title').' | '.app_name())

@push('after-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
    <script src="https://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>
    <style>
        .select2-container--default .select2-selection--single {
            height: 35px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 35px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 35px;
        }

        .bootstrap-tagsinput {
            width: 100% !important;
            display: inline-block;
        }

        .bootstrap-tagsinput .tag {
            line-height: 1;
            margin-right: 2px;
            background-color: #2f353a;
            color: white;
            padding: 3px;
            border-radius: 3px;
        }

    </style>

@endpush
@section('content')
    {!! Form::model($lesson, ['method' => 'PUT', 'route' => ['admin.lessons.update', $lesson->id], 'files' => true,]) !!}

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('labels.backend.lessons.edit')</h3>
            <div class="float-right">
                <a href="{{ route('admin.lessons.index') }}"
                   class="btn btn-success">@lang('labels.backend.lessons.view')</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('course_id', trans('labels.backend.lessons.fields.course'), ['class' => 'control-label']) !!}
                    {!! Form::select('course_id', $courses, old('course_id'), ['class' => 'form-control select2']) !!}
                </div>
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('title', trans('labels.backend.lessons.fields.title').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.lessons.fields.title'), 'required' => '']) !!}

                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('slug', trans('labels.backend.lessons.fields.slug'), ['class' => 'control-label']) !!}
                    {!! Form::text('slug', old('slug'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.lessons.slug_placeholder')]) !!}
                </div>
                @if ($lesson->lesson_image)

                    <div class="col-12 col-lg-5 form-group">

                        {!! Form::label('lesson_image', trans('labels.backend.lessons.fields.lesson_image').' '.trans('labels.backend.lessons.max_file_size'), ['class' => 'control-label']) !!}
                        {!! Form::file('lesson_image', ['class' => 'form-control', 'accept' => 'image/jpeg,image/gif,image/png', 'style' => 'margin-top: 4px;']) !!}
                        {!! Form::hidden('lesson_image_max_size', 8) !!}
                        {!! Form::hidden('lesson_image_max_width', 4000) !!}
                        {!! Form::hidden('lesson_image_max_height', 4000) !!}
                    </div>
                    <div class="col-lg-1 col-12 form-group">
                        <a href="{{ asset('uploads/'.$lesson->lesson_image) }}" target="_blank"><img
                                    src="{{ asset('uploads/'.$lesson->lesson_image) }}" height="65px"
                                    width="65px"></a>
                    </div>
                @else
                    <div class="col-12 col-lg-6 form-group">

                        {!! Form::label('lesson_image', trans('labels.backend.lessons.fields.lesson_image').' '.trans('labels.backend.lessons.max_file_size'), ['class' => 'control-label']) !!}
                        {!! Form::file('lesson_image', ['class' => 'form-control']) !!}
                        {!! Form::hidden('lesson_image_max_size', 8) !!}
                        {!! Form::hidden('lesson_image_max_width', 4000) !!}
                        {!! Form::hidden('lesson_image_max_height', 4000) !!}
                    </div>
                @endif

            </div>

            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('short_text', trans('labels.backend.lessons.fields.short_text'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('short_text', old('short_text'), ['class' => 'form-control ', 'placeholder' => trans('labels.backend.lessons.short_description_placeholder')]) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('full_text', trans('labels.backend.lessons.fields.full_text'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('full_text', old('full_text'), ['class' => 'form-control ckeditor', 'placeholder' => '','id' => 'editor']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('downloadable_files', trans('labels.backend.lessons.fields.downloadable_files').' '.trans('labels.backend.lessons.max_file_size'), ['class' => 'control-label']) !!}
                    {!! Form::file('downloadable_files[]', [
                        'multiple',
                        'class' => 'form-control file-upload',
                         'id' => 'downloadable_files',
                        'accept' => "image/jpeg,image/gif,image/png,application/msword,audio/mpeg,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/vnd.ms-powerpoint,application/pdf,video/mp4"

                        ]) !!}
                    <div class="photo-block mt-3">
                        <div class="files-list">
                            @if(count($lesson->downloadableMedia) > 0)
                                @foreach($lesson->downloadableMedia as $media)
                                    <p class="form-group">
                                        <a href="{{ asset('storage/uploads/'.$media->name) }}"
                                           target="_blank">{{ $media->name }}
                                            ({{ $media->size }} KB)</a>
                                        <a href="#" data-media-id="{{$media->id}}"
                                           class="btn btn-xs btn-danger delete remove-file">@lang('labels.backend.lessons.remove')</a>
                                    </p>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('pdf_files', trans('labels.backend.lessons.fields.add_pdf'), ['class' => 'control-label']) !!}
                    {!! Form::file('add_pdf', [
                        'class' => 'form-control file-upload',
                         'id' => 'add_pdf',
                        'accept' => "application/pdf"
                        ]) !!}
                    <div class="photo-block mt-3">
                        <div class="files-list">
                            @if($lesson->mediaPDF)
                                <p class="form-group">
                                    <a href="{{ asset('storage/uploads/'.$lesson->mediaPDF->name) }}"
                                       target="_blank">{{ $lesson->mediaPDF->name }}
                                        ({{ $lesson->mediaPDF->size }} KB)</a>
                                    <a href="#" data-media-id="{{$lesson->mediaPDF->id}}"
                                       class="btn btn-xs btn-danger delete remove-file">@lang('labels.backend.lessons.remove')</a>
                                    <iframe src="{{asset('storage/uploads/'.$lesson->mediaPDF->name)}}" width="100%" height="500px">
                                    </iframe>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('pdf_files', trans('labels.backend.lessons.fields.add_audio'), ['class' => 'control-label']) !!}
                    {!! Form::file('add_audio', [
                        'class' => 'form-control file-upload',
                         'id' => 'add_audio',
                        'accept' => "audio/mpeg3"
                        ]) !!}
                    <div class="photo-block mt-3">
                        <div class="files-list">
                            @if($lesson->mediaAudio)
                                <p class="form-group">
                                    <a href="{{ asset('storage/uploads/'.$lesson->mediaAudio->name) }}"
                                       target="_blank">{{ $lesson->mediaAudio->name }}
                                        ({{ $lesson->mediaAudio->size }} KB)</a>
                                    <a href="#" data-media-id="{{$lesson->mediaAudio->id}}"
                                       class="btn btn-xs btn-danger delete remove-file">@lang('labels.backend.lessons.remove')</a>
                                    <audio id="player" controls>
                                        <source src="{{ $lesson->mediaAudio->url }}" type="audio/mp3" />
                                    </audio>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    {!! Form::label('add_video', trans('labels.backend.lessons.fields.add_video'), ['class' => 'control-label']) !!}
                    {!! Form::select('media_type', ['youtube' => 'Youtube','vimeo' => 'Vimeo','upload' => 'Upload','embed' => 'Embed'],($lesson->mediavideo) ? $lesson->mediavideo->type : null,['class' => 'form-control', 'placeholder' => 'Select One','id'=>'media_type' ]) !!}


                    {!! Form::text('video', ($lesson->mediavideo) ? $lesson->mediavideo->url : null, ['class' => 'form-control mt-3 d-none', 'placeholder' => trans('labels.backend.lessons.enter_video_url'),'id'=>'video'  ]) !!}

                    {!! Form::file('video_file', ['class' => 'form-control mt-3 d-none', 'placeholder' => trans('labels.backend.lessons.enter_video_url'),'id'=>'video_file','accept' =>'video/mp4'  ]) !!}
                    <input type="hidden" name="old_video_file"
                           value="{{($lesson->mediavideo && $lesson->mediavideo->type == 'upload') ? $lesson->mediavideo->url  : ""}}">


                    @if($lesson->mediavideo && ($lesson->mediavideo->type == 'upload'))
                        <video width="300" class="mt-2 d-none video-player" controls>
                            <source src="{{($lesson->mediavideo && $lesson->mediavideo->type == 'upload') ? $lesson->mediavideo->url  : ""}}"
                                    type="video/mp4">
                            Your browser does not support HTML5 video.
                        </video>
                    @endif

                    @lang('labels.backend.lessons.video_guide')
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-3  form-group">
                    {!! Form::hidden('published', 0) !!}
                    {!! Form::checkbox('published', 1, old('published'), []) !!}
                    {!! Form::label('published', trans('labels.backend.lessons.fields.published'), ['class' => 'control-label control-label font-weight-bold']) !!}
                </div>
                <div class="col-12  text-left form-group">
                    {!! Form::submit(trans('strings.backend.general.app_update'), ['class' => 'btn  btn-primary']) !!}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@push('after-scripts')
    <script src="{{asset('plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
    <script src="{{asset('/vendor/laravel-filemanager/js/lfm.js')}}"></script>
    <script>
        CKEDITOR.replace('editor', {
            height : 300,
            filebrowserUploadUrl: `{{route('admin.ckeditor_fileupload',['_token' => csrf_token() ])}}`,
            filebrowserUploadMethod: 'form',
            extraPlugins: 'font,widget,colorbutton,colordialog,justify',
        });

        $(document).ready(function () {
            $(document).on('click', '.delete', function (e) {
                e.preventDefault();
                var parent = $(this).parent('.form-group');
                var confirmation = confirm('{{trans('strings.backend.general.are_you_sure')}}')
                if (confirmation) {
                    var media_id = $(this).data('media-id');
                    $.post('{{route('admin.media.destroy')}}', {media_id: media_id, _token: '{{csrf_token()}}'},
                        function (data, status) {
                            if (data.success) {
                                parent.remove();
                            } else {
                                alert('Something Went Wrong')
                            }
                        });
                }
            })
        });

        var uploadField = $('input[type="file"]');


        $(document).on('change', 'input[name="lesson_image"]', function () {
            var $this = $(this);
            $(this.files).each(function (key, value) {
                if (value.size > 5000000) {
                    alert('"' + value.name + '"' + 'exceeds limit of maximum file upload size')
                    $this.val("");
                }
            })
        });

        @if($lesson->mediavideo)
        @if($lesson->mediavideo->type !=  'upload')
        $('#video').removeClass('d-none').attr('required', true);
        $('#video_file').addClass('d-none').attr('required', false);
        $('.video-player').addClass('d-none');
        @elseif($lesson->mediavideo->type == 'upload')
        $('#video').addClass('d-none').attr('required', false);
        $('#video_file').removeClass('d-none').attr('required', false);
        $('.video-player').removeClass('d-none');
        @else
        $('.video-player').addClass('d-none');
        $('#video_file').addClass('d-none').attr('required', false);
        $('#video').addClass('d-none').attr('required', false);
        @endif
        @endif

        $(document).on('change', '#media_type', function () {
            if ($(this).val()) {
                if ($(this).val() != 'upload') {
                    $('#video').removeClass('d-none').attr('required', true);
                    $('#video_file').addClass('d-none').attr('required', false);
                    $('.video-player').addClass('d-none')
                } else if ($(this).val() == 'upload') {
                    $('#video').addClass('d-none').attr('required', false);
                    $('#video_file').removeClass('d-none').attr('required', true);
                    $('.video-player').removeClass('d-none')
                }
            } else {
                $('#video_file').addClass('d-none').attr('required', false);
                $('#video').addClass('d-none').attr('required', false)
            }
        })

    </script>
@endpush
