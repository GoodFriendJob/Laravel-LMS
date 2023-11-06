@extends('backend.layouts.app')
@section('title', __('labels.backend.general_settings.contact.title').' | '.app_name())

@push('after-styles')
    <link rel="stylesheet" href="{{asset('plugins/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css')}}"/>

    <link rel="stylesheet" href="{{asset('assets/css/colors/switch.css')}}">
    <style>
        .color-list li {
            float: left;
            width: 8%;
        }

        .options {
            line-height: 35px;
        }

        .color-list li a {
            font-size: 20px;
        }

        .color-list li a.active {
            border: 4px solid grey;
        }

        .color-default {
            font-size: 18px !important;
            background: #101010;
            border-radius: 100%;
        }

        .form-control-label {
            line-height: 35px;
        }

        .switch.switch-3d {
            margin-bottom: 0px;
            vertical-align: middle;

        }

        .color-default i {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .preview {
            background-color: #dcd8d8;
            background-image: url(https://www.transparenttextures.com/patterns/carbon-fibre-v2.png);
        }
    </style>
@endpush
@section('content')
    {{ html()->form('POST', route('admin.general-settings'))->id('general-settings-form')->class('form-horizontal')->acceptsFiles()->open() }}

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-5">
                    <h3 class="page-title d-inline">@lang('labels.backend.general_settings.contact.title')</h3>
                </div>
            </div>
        </div>

        <div class="card-body" id="contact">

            <input type="hidden" name="contact_data" id="contact_data">

            <div class="form-group row">
                {{ html()->label(__('labels.backend.general_settings.contact.short_text'))->class('col-md-2 form-control-label')->for('short_text') }}

                <div class="col-md-8">
                    {{ html()->text('')
                        ->id('short_text')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.general_settings.contact.short_text'))

                        ->value(config('contact.short_text'))
                        }}

                </div>
                <div class="col-md-2">
                    <p style="line-height: 35px">
                        <span class="mr-2">{{__('labels.backend.general_settings.contact.show')}}</span> {{ html()->label(html()->checkbox('')
                                        ->checked()->class('switch-input')->value(1)->checked()
                                  . '<span class="switch-label"></span><span class="switch-handle"></span>')
                              ->class('switch switch-sm switch-3d switch-primary')
                          }} </p>
                </div>
            </div>
            <div class="form-group row">
                {{ html()->label(__('labels.backend.general_settings.contact.primary_address'))->class('col-md-2 form-control-label')->for('primary_address') }}

                <div class="col-md-8">
                    {{ html()->text('')
                    ->id('primary_address')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.general_settings.contact.primary_address'))

                        ->value(config('contact.primary_address'))
                        }}

                </div>
                <div class="col-md-2">
                    <p style="line-height: 35px">
                        <span class="mr-2">{{__('labels.backend.general_settings.contact.show')}}</span> {{ html()->label(html()->checkbox('')
                                        ->checked()->class('switch-input')->value(1)->checked()
                                  . '<span class="switch-label"></span><span class="switch-handle"></span>')
                              ->class('switch switch-sm switch-3d switch-primary')
                          }} </p>
                </div>

            </div>
            <div class="form-group row">

                {{ html()->label(__('labels.backend.general_settings.contact.secondary_address'))->class('col-md-2 form-control-label')->for('secondary_address') }}

                <div class="col-md-8">
                    {{ html()->text('')
                    ->id('secondary_address')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.general_settings.contact.secondary_address'))
                        ->value(config('contact.secondary_address'))
                        }}

                </div>
                <div class="col-md-2">
                    <p style="line-height: 35px">
                        <span class="mr-2">{{__('labels.backend.general_settings.contact.show')}}</span> {{ html()->label(html()->checkbox('')
                                        ->class('switch-input')->value(1)->checked()
                                  . '<span class="switch-label"></span><span class="switch-handle"></span>')
                              ->class('switch switch-sm switch-3d switch-primary')
                          }} </p>
                </div>
            </div>
            <div class="form-group row">

                {{ html()->label(__('labels.backend.general_settings.contact.primary_phone'))->class('col-md-2 form-control-label')->for('primary_phone') }}

                <div class="col-md-8">
                    {{ html()->text()
                    ->id('primary_phone')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.general_settings.contact.primary_phone'))

                        ->value(config('contact.primary_phone'))
                        }}

                </div>
                <div class="col-md-2">
                    <p style="line-height: 35px">
                        <span class="mr-2">{{__('labels.backend.general_settings.contact.show')}}</span> {{ html()->label(html()->checkbox('')
                                        ->class('switch-input')->value(1)->checked()
                                  . '<span class="switch-label"></span><span class="switch-handle"></span>')
                              ->class('switch switch-sm switch-3d switch-primary')
                          }} </p>
                </div>
            </div>
            <div class="form-group row">
                {{ html()->label(__('labels.backend.general_settings.contact.secondary_phone'))->class('col-md-2 form-control-label')->for('secondary_phone') }}

                <div class="col-md-8">
                    {{ html()->text()
                    ->id('secondary_phone')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.general_settings.contact.secondary_phone'))

                        ->value(config('contact.secondary_phone'))
                        }}
                </div>
                <div class="col-md-2">
                    <p style="line-height: 35px">
                        <span class="mr-2">{{__('labels.backend.general_settings.contact.show')}}</span> {{ html()->label(html()->checkbox('')
                                        ->class('switch-input')->value(1)->checked()
                                  . '<span class="switch-label"></span><span class="switch-handle"></span>')
                              ->class('switch switch-sm switch-3d switch-primary')
                          }} </p>
                </div>
            </div>
            <div class="form-group row">

                {{ html()->label(__('labels.backend.general_settings.contact.primary_email'))->class('col-md-2 form-control-label')->for('primary_email') }}

                <div class="col-md-8">
                    {{ html()->email('')
                    ->id('primary_email')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.general_settings.contact.primary_email'))

                        ->value(config('contact.primary_email'))
                        }}


                </div>
                <div class="col-md-2">
                    <p style="line-height: 35px">
                        <span class="mr-2">{{__('labels.backend.general_settings.contact.show')}}</span> {{ html()->label(html()->checkbox('')
                                        ->class('switch-input')->value(1)->checked()
                                  . '<span class="switch-label"></span><span class="switch-handle"></span>')
                              ->class('switch switch-sm switch-3d switch-primary')
                          }} </p>
                </div>
            </div>
            <div class="form-group row">
                {{ html()->label(__('labels.backend.general_settings.contact.secondary_email'))->class('col-md-2 form-control-label')->for('secondary_email') }}

                <div class="col-md-8">
                    {{ html()->email('')
                    ->id('secondary_email')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.general_settings.contact.secondary_email'))

                        ->value(config('contact.secondary_email'))
                        }}
                </div>
                <div class="col-md-2">
                    <p style="line-height: 35px">
                        <span class="mr-2">{{__('labels.backend.general_settings.contact.show')}}</span> {{ html()->label(html()->checkbox('')
                                        ->class('switch-input')->value(1)->checked()
                                  . '<span class="switch-label"></span><span class="switch-handle"></span>')
                              ->class('switch switch-sm switch-3d switch-primary')
                          }} </p>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-6 border-right">
                    <div class="row">
                        {{ html()->label(__('labels.backend.general_settings.contact.location_on_map'))->class('col-md-12 form-control-label')->for('location_on_map') }}

                        <div class="col-md-12">
                            {{ html()->textarea('')
                            ->id('location_on_map')
                                ->class('form-control')
                                ->attributes(['rows'=>9])
                                ->placeholder(__('labels.backend.general_settings.contact.location_on_map'))

                                ->value(config('contact.location_on_map'))
                                }}

                        </div>
                        <div class="col-md-12">
                            <p style="line-height: 35px">
                                <span class="mr-2">{{__('labels.backend.general_settings.contact.show')}}</span> {{ html()->label(html()->checkbox('')
                                        ->checked()->class('switch-input')->value(1)->checked()
                                  . '<span class="switch-label"></span><span class="switch-handle"></span>')
                              ->class('switch switch-sm switch-3d switch-primary')
                          }} </p>
                        </div>
                    </div>

                </div>

                <div class="col-6">
                    {!! __('labels.backend.general_settings.contact.map_note') !!}
                </div>

            </div>
        </div>
        <div class="card-footer clearfix">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.general-settings'), __('buttons.general.cancel')) }}
                </div><!--col-->
                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.update'))->id('submit') }}
                </div><!--col-->
            </div><!--row-->
        </div><!--card-footer-->
    </div>


    {{ html()->form()->close() }}

@endsection


@push('after-scripts')
    <script>
        //=========Preset contact data ==========//
       @if(config('contact_data'))
            var contact_data = {!! config('contact_data') !!};


        $(contact_data).each(function (key, element) {
            if (element.name == 'location_on_map') {
                $('#' + element.name).html(element.value);

            } else {
                $('#' + element.name).val(element.value)
            }

            if (element.status == 1) {
                $('#' + element.name).parents('.form-group').find('input[type="checkbox"]').attr('checked', true);
            } else {
                $('#' + element.name).parents('.form-group').find('input[type="checkbox"]').attr('checked', false);
            }
        });
        @endif


        $(document).on('submit', '#general-settings-form', function (e) {
//                            e.preventDefault();
            //============Saving Contact Details=====//
            var dataJson = {};
            var inputs = $('#contact').find('input[type="text"],textarea,input[type="email"]');
            var data = [];
            var val, name, status
            $(inputs).each(function (key, value) {
                name = $(value).attr('id')
                if (name == 'location_on_map') {
                    val = $(value).val().replace(/"/g, "'")
                } else {
                    val = $(value).val()
                }
                status = ($(value).parents('.form-group').find('input[type="checkbox"]:checked').val()) ? 1 : 0;
                data.push({name: name, value: val, status: status});
            });
            dataJson = JSON.stringify(data);
            $('#contact_data').val(dataJson);
        });
    </script>
@endpush