@extends('backend.layouts.app')
@section('title', __('labels.backend.hero_slider.title').' | '.app_name())

@push('after-styles')
    <style>
        .form-control-label {
            line-height: 35px;
        }

        .remove {
            float: right;
            color: red;
            font-size: 20px;
            cursor: pointer;
        }

        .error {
            color: red;
        }

    </style>

    <link rel="stylesheet" type="text/css"
          href="{{asset('plugins/jqueryui-datetimepicker/jquery.datetimepicker.css')}}">
@endpush
@section('content')
    {{ html()->modelForm($slide, 'PATCH', route('admin.sliders.update', $slide->id))->class('form-horizontal')->acceptsFiles()->id('slider-create')->open() }}
    <div class="alert alert-danger d-none" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <div class="error-list">
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">@lang('labels.backend.hero_slider.edit')</h3>
            <div class="float-right">
                <a href="{{ route('admin.sliders.index') }}"
                   class="btn btn-success">@lang('labels.backend.hero_slider.view')</a>

            </div>
        </div>
        <div class="card-body">

            <div class="row form-group">
                {{ html()->label(__('labels.backend.hero_slider.fields.name'))->class('col-md-2 form-control-label')->for('first_name') }}

                <div class="col-md-10">
                    {{ html()->text('name')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.hero_slider.fields.name'))
                        ->attribute('maxlength', 191)
                    ->autofocus()
                    }}
                </div><!--col-->
            </div>
            <div class="row form-group">
                {{ html()->label(__('labels.backend.hero_slider.fields.bg_image'))->class('col-md-2 form-control-label')->for('image') }}

                <div class="col-md-8">
                    {!! Form::file('image', ['class' => 'form-control d-inline-block', 'placeholder' => '', 'accept' => 'image/jpeg,image/gif,image/png']) !!}
                    <p class="help-text mb-0 font-italic">{!!  __('labels.backend.hero_slider.note')!!}</p>
                    {!! Form::hidden('slide_image_max_size', 8) !!}
                    {!! Form::hidden('slide_image_max_width', 4000) !!}
                    {!! Form::hidden('slide_image_max_height', 4000) !!}
                    <input type="hidden" value="{{$slide->bg_image}}" name="old_image">
                </div>
                <div class="col-md-2">
                    <img src="{{asset('storage/uploads/'.$slide->bg_image)}}" height="50px">
                </div>
            </div>
            <div class="row form-group">
                {{ html()->label(__('labels.backend.hero_slider.fields.overlay.title'))->class('col-md-2 form-control-label')->for('overlay') }}

                <div class="col-md-10">
                    {{ html()->label(html()->checkbox('overlay')
                                              ->class('switch-input')->value(1)
                                        . '<span class="switch-label"></span><span class="switch-handle"></span>')
                                    ->class('switch switch-sm switch-3d switch-primary')
                                }}
                    <p class="help-text mb-0 font-italic">{!!  __('labels.backend.hero_slider.fields.overlay.note')!!}</p>
                </div>
            </div>
            <div class="row form-group">
                {{ html()->label(__('labels.backend.hero_slider.fields.hero_text'))->class('col-md-2 form-control-label')->for('hero_text') }}

                <div class="col-md-10">
                    {{ html()->text('hero_text')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.hero_slider.fields.hero_text'))
                        }}
                </div>
            </div>
            <div class="row form-group">
                {{ html()->label(__('labels.backend.hero_slider.fields.sub_text'))->class('col-md-2 form-control-label')->for('sub_text') }}
                <div class="col-md-10">
                    {{ html()->text('sub_text')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.hero_slider.fields.sub_text'))
                         }}
                </div><!--col-->
            </div>
            <div class="row form-group">
                {{ html()->label(__('labels.backend.hero_slider.fields.widget.title'))->class('col-md-2 form-control-label')->for('widget') }}
                <div class="col-md-10">
                    {!! Form::select('widget', [""=>trans('labels.backend.hero_slider.fields.widget.select_widget'),1=>trans('labels.backend.hero_slider.fields.widget.search_bar'),2=>trans('labels.backend.hero_slider.fields.widget.countdown_timer')],  (request('widget')) ? request('widget') : old('widget'), ['class' => 'form-control ', 'id'=>'widget']) !!}

                    <div class="widget-container mt-2 d-none">
                        {{ html()->text('timer')
                           ->class('form-control')
                           ->placeholder(trans('labels.backend.hero_slider.fields.widget.input_date_time'))
                         ->id('timer')
                       }}
                    </div>
                </div><!--col-->
            </div>
            <div class="row form-group">
                {{ html()->label(__('labels.backend.hero_slider.fields.buttons.title'))->class('col-md-2 col-2 form-control-label')->for('buttons') }}
                <div class="col-2">
                    <button type="button" id="add-button"
                            class="btn-block btn  btn-primary">{{__('labels.backend.hero_slider.fields.buttons.add')}}</button>
                </div>


                <div class="col-md-8 col-8">
                    {{--{{ html()->input('number','buttons')--}}
                    {{--->class('form-control')--}}
                    {{--->placeholder(__('labels.backend.hero_slider.fields.buttons.placeholder'))--}}
                    {{--->attributes(['max'=>4,'pattern'=>'[0-9]','min'=>1])--}}
                    {{--->id('buttons')--}}
                    {{--}}--}}
                    <p class="help-text mb-0 font-italic">{!!  __('labels.backend.hero_slider.fields.buttons.note')!!}</p>
                </div><!--col-->
                <div class="col-12 col-md-10 ml-auto button-container mt-2">

                </div>

            </div>

            <div class="form-group row justify-content-center">
                <div class="col-4">
                    {{ form_cancel(route('admin.sliders.index'), __('buttons.general.cancel')) }}

                    <button class="btn btn-success pull-right" type="button"
                            id="btn-submit">{{__('buttons.general.crud.update')}}</button>
                </div>
            </div><!--col-->
        </div>
    </div>
    {{ html()->form()->close() }}
@endsection

@push('after-scripts')
    <script src="{{asset('plugins/jqueryui-datetimepicker/jquery.datetimepicker.full.min.js')}}"></script>

    <script src="{{asset('js/slider-form.js')}}"></script>
    <script>

        $(document).ready(function () {
            $(".js-example-placeholder-single").select2({
                placeholder: "{{trans('labels.backend.hero_slider.fields.widget.select_widget')}}",
            });




            $(document).on('change', '#widget', function () {
                if ($(this).val() == 2) {
                    $('.widget-container').removeClass('d-none');
                } else {
                    $('.widget-container').addClass('d-none');
                }
            })

            $(document).on('click', '#add-button', function (e) {
                e.preventDefault()
                if ($('.button-wrapper').length <= 3) {
                    var name ='Button';
                    var html = "<div class='button-wrapper'> <h6 class='mt-3'> " + name + " <span class='remove'><i class='fa fa-window-close'></i></span></h6>" +
                        "<div class='row'>" +
                        "<div class='col-lg-6'>" +
                        "<input type='text' required name='button_label' class='form-control' placeholder='Button label'>" +
                        "</div>" +
                        "<div class='col-lg-6'>" +
                        "<input type='text' required name='button_link' class='form-control' placeholder='Button Link'>" +
                        "</div>" +
                        "</div></div>";

                    $('.button-container').append(html);
                } else {
                    alert('Maximum limit of button exceeded!')
                }
            });

            $(document).on('click', '.remove', function () {
                if (confirm('Are you sure want to remove button?')) {
                    $(this).parents('.button-wrapper').remove();
                }
            })
            var date;
           @if($slide->content != "")
            var dataJson = "{{$slide->content}}";
            dataJson = JSON.parse(dataJson.replace(/&quot;/g, '"'));

            //Adding texts
            $('input[name="hero_text"]').val(dataJson.hero_text);
            $('input[name="sub_text"]').val(dataJson.sub_text);

            //Adding widgets

            if(dataJson.widget){
                if(dataJson.widget.type == 1){
                    $('select[name="widget"] option:eq(1)').prop('selected', true)
                    date = new Date();

                }else{
                    $('select[name="widget"] option:eq(2)').prop('selected', true);
                    $('.widget-container ').removeClass('d-none');
                    date = dataJson.widget.timer;
                }

            }

            //Adding buttons
            if(dataJson.buttons){
                $(dataJson.buttons).each(function (key,data) {
                    var name = 'Button';
                    var html = "<div class='button-wrapper'> <h6 class='mt-3'> " + name + " <span class='remove'><i class='fa fa-window-close'></i></span></h6>" +
                        "<div class='row'>" +
                        "<div class='col-lg-6'>" +
                        "<input type='text' value='"+data.label+"' required name='button_label' class='form-control' placeholder='Button label'>" +
                        "</div>" +
                        "<div class='col-lg-6'>" +
                        "<input type='text' required name='button_link' value='"+data.link+"' class='form-control' placeholder='Button Link'>" +
                        "</div>" +
                        "</div></div>";

                    $('.button-container').append(html);
                });

            }

            @endif




            $('#timer').datetimepicker({
                mask: true,
                value:date
            });



        })
    </script>
@endpush
