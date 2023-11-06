@extends('backend.layouts.app')
@section('title', __('labels.backend.tests.title').' | '.app_name())

@push('after-styles')
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

    </style>
@endpush
@section('content')
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">


    <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="https://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>

    {!! Form::open(['method' => 'POST', 'route' => ['admin.tests.store']]) !!}

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('labels.backend.tests.create')</h3>
            <div class="float-right">
                <a href="{{ route('admin.tests.index') }}"
                   class="btn btn-success">@lang('labels.backend.tests.view')</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('course_id', trans('labels.backend.tests.fields.course'), ['class' => 'control-label']) !!}
                    {!! Form::select('course_id', $courses, old('course_id'), ['class' => 'form-control select2']) !!}

                </div>

                <div class="col-12 col-lg-6  form-group">
                    {!! Form::label('title',trans('labels.backend.tests.fields.title'), ['class' => 'control-label']) !!}
                    {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.tests.fields.title')]) !!}

                </div>
            </div>

            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('description',trans('labels.backend.tests.fields.description'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('description', old('description'), ['class' => 'form-control ', 'placeholder' => trans('labels.backend.tests.fields.description')]) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('text1', trans('labels.backend.tests.fields.text1'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('text1', "&nbsp", ['class' => 'form-control ckeditor', 'placeholder' => '','name'=>'text1','id' => 'text1']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('text2', trans('labels.backend.tests.fields.text2'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('text2',"&nbsp", ['class' => 'form-control ckeditor', 'placeholder' => '','name'=>'text2','id' => 'text2']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('color1',trans('labels.backend.tests.fields.color1'), ['class' => 'control-label']) !!}
                    {!! Form::color('color1', old('color1'), ['class' => 'form-control ']) !!}
                </div>
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('color2',trans('labels.backend.tests.fields.color2'), ['class' => 'control-label']) !!}
                    {!! Form::color('color2', old('color2'), ['class' => 'form-control ']) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::hidden('published', 0) !!}
                    {!! Form::checkbox('published', 1, false, []) !!}
                    {!! Form::label('published', trans('labels.backend.tests.fields.published'), ['class' => 'control-label font-weight-bold']) !!}
                </div>
            </div>
        </div>
    </div>

    {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}

    <script>
        CKEDITOR.replace('text1', {
            height : 150,
            filebrowserUploadUrl: `{{route('admin.questions.editor_fileupload',['_token' => csrf_token() ])}}`,
            filebrowserUploadMethod: 'form',
            extraPlugins: 'font,widget,colorbutton,colordialog,justify',
            startupFocus: true,
        });
        CKEDITOR.replace('text2', {
            height : 150,
            filebrowserUploadUrl: `{{route('admin.questions.editor_fileupload',['_token' => csrf_token() ])}}`,
            filebrowserUploadMethod: 'form',
            extraPlugins: 'font,widget,colorbutton,colordialog,justify',
            startupFocus: true,
        });
        $(".btn.btn-danger").bind("click",function(){
            var cont=CKEDITOR.instances["text1"].editable().$.innerHTML;
            var pos=cont.indexOf("</span>");
            cont=cont.slice(0,pos)+"&nbsp"+cont.slice(pos,);
            CKEDITOR.instances["text1"].setData(cont);
            cont=CKEDITOR.instances["text2"].editable().$.innerHTML;
            pos=cont.indexOf("</span>");
            cont=cont.slice(0,pos)+"&nbsp"+cont.slice(pos,);
            CKEDITOR.instances["text2"].setData(cont);
        })
    </script>
@stop


