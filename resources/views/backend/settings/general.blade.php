@extends('backend.layouts.app')
@section('title', __('labels.backend.general_settings.title').' | '.app_name())

@push('after-styles')
    <link rel="stylesheet" href="{{asset('plugins/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css')}}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{asset('assets/css/colors/switch.css')}}">
    <style>
        .color-list li {
            float: left;
            width: 8%;
        }

        @media screen  and (max-width: 768px) {
            .color-list li {
                width: 20%;
                padding-bottom: 20px;
            }

            .color-list li:first-child {
                padding-bottom: 0px;
            }
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

        #logos img {
            height: auto;
            width: 100%;
        }
    </style>
@endpush
@section('content')
    {{ html()->form('POST', route('admin.general-settings'))->id('general-settings-form')->class('form-horizontal')->acceptsFiles()->open() }}

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="nav main-nav-tabs nav-tabs">
                        <li class="nav-item"><a data-toggle="tab" class="nav-link active " href="#general">
                                {{__('labels.backend.general_settings.title')}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link" href="#logos">
                                {{ __('labels.backend.general_settings.logos.title') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link" href="#layout">
                                {{ __('labels.backend.general_settings.layout.title') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link" href="#email">
                                {{ __('labels.backend.general_settings.email.title') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link" href="#payment_settings">
                                {{ __('labels.backend.general_settings.payment_settings.title') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link" href="#language_settings">
                                {{ __('labels.backend.general_settings.language_settings.title') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link" href="#user_registration_settings">
                                {{ __('labels.backend.general_settings.user_registration_settings.title') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link" href="#api_client_settings">
                                {{ __('labels.backend.general_settings.api_clients.title') }}
                            </a>
                        </li>
                    </ul>
                    <h4 class="card-title mb-0">
                        {{--{{ __('labels.backend.general_settings.management') }}--}}
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <div class="tab-content">
                <!---General Tab--->
                <div id="general" class="tab-pane container active">
                    <div class="row mt-4 mb-4">
                        <div class="col ">
                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.app_name'))->class('col-md-2 form-control-label')->for('app_name') }}

                                <div class="col-md-10">
                                    {{ html()->text('app__name')
                                        ->class('form-control')
                                        ->placeholder(__('labels.backend.general_settings.app_name'))
                                        ->attribute('maxlength', 191)

                                        ->value(config('app.name'))
                                        ->autofocus()
                                        }}

                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.app_url'))->class('col-md-2 form-control-label')->for('app_url') }}

                                <div class="col-md-10">
                                    {{ html()->text('app__url')
                                        ->class('form-control')
                                        ->placeholder(__('labels.backend.general_settings.app_url'))
                                        ->attribute('maxlength', 191)

                                        ->value(config('app.url'))
                                        }}

                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.font_color'))->class('col-md-2 form-control-label')->for('font_color') }}

                                <div class="col-md-10">
                                    <ul class="d-inline-block list-inline w-100 mb-0 color-list list-style-none">
                                        <li>
                                            <a data-color="default" class="color-default"
                                               href="#!"><i
                                                        class="fas fa-circle"></i></a>
                                            <p class="mb-0" style="font-size: 10px">(Default)</p>
                                        </li>
                                        <li>
                                            <a data-color="color-2" class="color-2"
                                               onclick="setActiveStyleSheet('color-2'); return true;" href="#!"><i
                                                        class="fas fa-circle"></i></a>
                                        </li>
                                        <li>
                                            <a data-color="color-3" class="color-3"
                                               onclick="setActiveStyleSheet('color-3'); return true;" href="#!"><i
                                                        class="fas fa-circle"></i></a>
                                        </li>
                                        <li>
                                            <a data-color="color-4" class="color-4"
                                               onclick="setActiveStyleSheet('color-4'); return true;" href="#!"><i
                                                        class="fas fa-circle"></i></a>
                                        </li>
                                        <li>
                                            <a data-color="color-5" class="color-5"
                                               onclick="setActiveStyleSheet('color-5'); return true;" href="#!"><i
                                                        class="fas fa-circle"></i></a>
                                        </li>
                                        <li>
                                            <a data-color="color-6" class="color-6"
                                               onclick="setActiveStyleSheet('color-6'); return true;" href="#!"><i
                                                        class="fas fa-circle"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a data-color="color-7" class="color-7"
                                               onclick="setActiveStyleSheet('color-7'); return true;" href="#!"><i
                                                        class="fas fa-circle"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a data-color="color-8" class="color-8"
                                               onclick="setActiveStyleSheet('color-8'); return true;" href="#!"><i
                                                        class="fas fa-circle"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a data-color="color-9" class="color-9"
                                               onclick="setActiveStyleSheet('color-9'); return true;" href="#!"><i
                                                        class="fas fa-circle"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    <input type="hidden" name="font_color" id="font_color" value="default">
                                    <span class="help-text font-italic">This will change frontend theme font colors</span>
                                </div><!--col-->
                            </div><!--form-group-->


                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.counter'))->class('col-md-2 form-control-label')->for('counter') }}

                                <div class="col-md-10">
                                    <select class="form-control" id="counter" name="counter">
                                        <option selected
                                                value="1">{{__('labels.backend.general_settings.static')}}</option>
                                        <option value="2">{{__('labels.backend.general_settings.database')}}</option>
                                    </select>
                                    <span class="help-text font-italic">{!!  __('labels.backend.general_settings.counter_note') !!}</span>
                                    <div class="counter-container" id="counter-container">

                                        <input class="form-control my-2" type="text" id="total_students" required
                                               name="total_students"
                                               placeholder="{{__('labels.backend.general_settings.total_students')}}">

                                        <input type="text" required id="total_courses" class="form-control mb-2"
                                               name="total_courses"
                                               placeholder="{{__('labels.backend.general_settings.total_courses')}}">

                                        <input type="text" required class="form-control mb-2" id="total_teachers"
                                               name="total_teachers"
                                               placeholder="{{__('labels.backend.general_settings.total_teachers')}}">
                                    </div>

                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.google_analytics_id'))->class('col-md-2 form-control-label')->for('app_name') }}

                                <div class="col-md-10">
                                    {{ html()->text('google_analytics_id')
                                        ->class('form-control')
                                        ->placeholder('Ex. UA-34XXXXX23-3')
                                        ->attribute('maxlength', 191)

                                        ->value(config('google_analytics_id'))
                                        ->autofocus()
                                        }}
                                    <span class="float-right">
                                        <a target="_blank" class="font-weight-bold font-italic"
                                           href="https://support.google.com/analytics/answer/1042508">{{__('labels.backend.general_settings.google_analytics_id_note')}}</a>
                                    </span>

                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                {{ html()->label(__('validation.attributes.backend.settings.general_settings.captcha_status'))->class('col-md-2 form-control-label')->for('captcha_status') }}
                                <div class="col-md-10">
                                    <div class="checkbox">
                                        {{ html()->label(
                                                html()->checkbox('access__captcha__registration', config('access.captcha.registration') ? true : false,1)->id('captcha_status')
                                                      ->class('switch-input')->value(1)
                                                . '<span class="switch-label"></span><span class="switch-handle"></span>')

                                            ->class('switch switch-sm switch-3d switch-primary')
                                        }}
                                    </div>
                                    <span class="float-right">
                                        <a target="_blank" class="font-weight-bold font-italic"
                                           href="https://support.google.com/analytics/answer/1042508">{{__('labels.backend.general_settings.captcha_note')}}</a>
                                    </span>
                                    <small><i>{{__('labels.backend.general_settings.captcha')}}</i></small>
                                    <div id="captcha-credentials"
                                         class="@if(config('access.captcha.registration') == 0 || config('access.captcha.registration') == false) d-none @endif">
                                        <br>
                                        <div class="form-group row">
                                            {{ html()->label(__('validation.attributes.backend.settings.general_settings.captcha_site_key'))->class('col-md-2 form-control-label')->for('captcha_site_key') }}
                                            <div class="col-md-10">
                                                {{ html()->text('no-captcha__sitekey')
                                                     ->class('form-control')
                                                     ->placeholder(__('validation.attributes.backend.settings.general_settings.captcha_site_key'))
                                                     ->value(config('no-captcha.sitekey'))
                                                     }}
                                            </div><!--col-->
                                        </div><!--form-group-->
                                        <div class="form-group row">
                                            {{ html()->label(__('validation.attributes.backend.settings.general_settings.captcha_site_secret'))->class('col-md-2 form-control-label')->for('captcha_site_secret') }}
                                            <div class="col-md-10">
                                                {{ html()->text('no-captcha__secret')
                                                     ->class('form-control')
                                                     ->placeholder(__('validation.attributes.backend.settings.general_settings.captcha_site_secret'))
                                                     ->value(config('no-captcha.secret'))
                                                     }}
                                            </div><!--col-->
                                        </div><!--form-group-->
                                    </div>

                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                {{ html()->label(__('validation.attributes.backend.settings.general_settings.retest_status'))->class('col-md-2 form-control-label')->for('retest') }}
                                <div class="col-md-10">
                                    <div class="checkbox">
                                        {{ html()->label(
                                                html()->checkbox('retest', config('retest') ? true : false,1)->id('retest')
                                                      ->class('switch-input')->value(1)
                                                . '<span class="switch-label"></span><span class="switch-handle"></span>')
                                            ->class('switch switch-sm switch-3d switch-primary')
                                        }}
                                    </div>
                                    <small><i> {{__('labels.backend.general_settings.retest_note')}}</i></small>
                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                {{ html()->label(__('validation.attributes.backend.settings.general_settings.lesson_timer'))->class('col-md-2 form-control-label')->for('lesson_timer') }}
                                <div class="col-md-10">
                                    <div class="checkbox">
                                        {{ html()->label(
                                                html()->checkbox('lesson_timer', config('lesson_timer') ? true : false,1)->id('retest')
                                                      ->class('switch-input')->value(1)
                                                . '<span class="switch-label"></span><span class="switch-handle"></span>')
                                            ->class('switch switch-sm switch-3d switch-primary')
                                        }}
                                    </div>
                                    <small><i> {{__('labels.backend.general_settings.lesson_note')}}</i></small>
                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                {{ html()->label(__('validation.attributes.backend.settings.general_settings.show_offers'))->class('col-md-2 form-control-label')->for('show_offers') }}
                                <div class="col-md-10">
                                    <div class="checkbox">
                                        {{ html()->label(
                                                html()->checkbox('show_offers', config('show_offers') ? true : false,1)->id('retest')
                                                      ->class('switch-input')->value(1)
                                                . '<span class="switch-label"></span><span class="switch-handle"></span>')
                                            ->class('switch switch-sm switch-3d switch-primary')
                                        }}
                                    </div>
                                    <small><i> {{__('labels.backend.general_settings.show_offers_note')}}</i></small>
                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                {{ html()->label(__('validation.attributes.backend.settings.general_settings.one_signal_push_notification'))->class('col-md-2 form-control-label')->for('onesignal_status') }}
                                <div class="col-md-10">
                                    <div class="checkbox">
                                        {{ html()->label(
                                                html()->checkbox('onesignal_status', config('onesignal_status') ? true : false,1)->id('onesignal_status')
                                                      ->class('switch-input')->value(1)
                                                . '<span class="switch-label"></span><span class="switch-handle"></span>')

                                            ->class('switch switch-sm switch-3d switch-primary')
                                        }}
                                    </div>
                                    <span class="float-right">
                                        <a target="_blank" class="font-weight-bold font-italic"
                                           href="https://documentation.onesignal.com/docs/web-push-quickstart">{{__('labels.backend.general_settings.how_to_onesignal')}}</a><br>
                                         <a target="_blank" class="font-weight-bold font-italic"
                                            href="https://documentation.onesignal.com/docs/web-push-custom-code-setup#section--span-class-step-step-3-span-upload-onesignal-sdk">{{__('labels.backend.general_settings.setup_onesignal')}}</a>
                                    </span>
                                    <small><i>{{__('labels.backend.general_settings.onesignal_note')}}</i></small>
                                    <div id="onesignal-configuration"
                                         class="@if(config('onesignal_status') == 0 || config('onesignal_status') == false) d-none @endif">
                                        <br>

                                        <div class="form-group row">

                                            <div class="col-md-12">
                                                {{ html()->textarea('onesignal_data')
                                                     ->class('form-control')
                                                     ->placeholder(__('validation.attributes.backend.settings.general_settings.onesignal_code'))
                                                     ->value(config('onesignal_data'))
                                                     }}
                                            </div><!--col-->
                                        </div><!--form-group-->
                                    </div>

                                </div><!--col-->
                            </div><!--form-group-->
                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.teacher_commission_rate'))->class('col-md-2 form-control-label mb-1')->for('commission_rate') }}

                                <div class="col-md-10">
                                    {{ html()->input('number','commission_rate')
                                        ->class('form-control')
                                        ->attributes(['pattern' => '[0-9]'])
                                        ->placeholder(__('labels.backend.general_settings.teacher_commission_rate'))
                                        ->value(config('commission_rate'))
                                        }}
                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.admin_registration_mail'))->class('col-md-2 form-control-label')->for('admin_registration_mail') }}
                                <div class="col-md-10">
                                    <div class="checkbox">
                                        {{ html()->label(
                                                html()->checkbox('access__users__registration_mail', config('access.users.registration_mail') ? true : false,1)->id('admin_registration_mail')
                                                      ->class('switch-input')->value(1)
                                                . '<span class="switch-label"></span><span class="switch-handle"></span>')
                                            ->class('switch switch-sm switch-3d switch-primary')
                                        }}
                                    </div>
                                    <small><i> {{__('labels.backend.general_settings.admin_registration_mail_note')}}</i></small>
                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.admin_order_mail'))->class('col-md-2 form-control-label')->for('admin_order_mail') }}
                                <div class="col-md-10">
                                    <div class="checkbox">
                                        {{ html()->label(
                                                html()->checkbox('access__users__order_mail', config('access.users.order_mail') ? true : false,1)->id('admin_order_mail')
                                                      ->class('switch-input')->value(1)
                                                . '<span class="switch-label"></span><span class="switch-handle"></span>')
                                            ->class('switch switch-sm switch-3d switch-primary')
                                        }}
                                    </div>
                                    <small><i> {{__('labels.backend.general_settings.admin_order_mail_note')}}</i></small>
                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.admin_report_mail'))->class('col-md-2 form-control-label')->for('admin_report_mail') }}
                                <div class="col-md-10">
                                    <div class="checkbox">
                                        {{ html()->label(
                                                html()->checkbox('access__users__report_mail', config('access.users.report_mail') ? true : false,1)->id('admin_report_mail')
                                                      ->class('switch-input')->value(1)
                                                . '<span class="switch-label"></span><span class="switch-handle"></span>')
                                            ->class('switch switch-sm switch-3d switch-primary')
                                        }}
                                    </div>
                                    <small><i> {{__('labels.backend.general_settings.admin_report_mail_note')}}</i></small>
                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.custom_css'))->class('col-md-2 form-control-label')->for('custom_css') }}

                                <div class="col-md-10">
                                    {{ html()->textarea('custom_css')
                                        ->class('form-control')
                                        ->placeholder(__('Ex. body{background:blue;}'))
                                        ->value(config('custom_css'))
                                        }}
                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.custom_js'))->class('col-md-2 form-control-label')->for('custom_js') }}

                                <div class="col-md-10">
                                    {{ html()->textarea('custom_js')
                                        ->class('form-control')
                                        ->placeholder(__("Ex. $('#Demo').on('click',function(){  alert(); })"))
                                        ->value(config('custom_js'))
                                        }}
                                </div><!--col-->
                            </div><!--form-group-->
                        </div>
                        <div class="col-12 text-left">
                            <a href="{{route('admin.troubleshoot')}}"
                               class="btn btn-lg btn-warning">{{__('labels.backend.general_settings.troubleshoot')}}</a>
                        </div>
                    </div>
                </div>

                <!---Logos Tab--->
                <div id="logos" class="tab-pane container fade">
                    <div class="row mt-4 mb-4">
                        <div class="col">
                            <div class="row form-group">
                                {{ html()->label(__('labels.backend.logo.logo_b'))->class('col-md-2 form-control-label')->for('logo_b_image') }}

                                <div class="col-md-10 ">
                                    {!! Form::file('logo_b_image', ['class' => 'form-control d-inline-block', 'placeholder' => '','id' => 'logo_b_image', 'accept' => 'image/jpeg,image/gif,image/png', 'data-preview'=>'#logo_b_image_preview']) !!}
                                    <p class="help-text mb-0 font-italic">{!!  __('labels.backend.logo.logo_b_note')!!}</p>
                                </div>
                                <div class="col-md-8 offset-md-2">
                                    <div id="logo_b_image_preview" class="d-inline-block p-3 preview">
                                        <img height="50px" src="{{asset('storage/logos/'.config('logo_b_image'))}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                {{ html()->label(__('labels.backend.logo.logo_w'))->class('col-md-2 form-control-label')->for('logo_w_image') }}

                                <div class="col-md-10">
                                    {!! Form::file('logo_w_image', ['class' => 'form-control d-inline-block', 'placeholder' => '', 'data-preview'=>'#logo_w_image_preview', 'id' => 'logo_w_image', 'accept' => 'image/jpeg,image/gif,image/png']) !!}
                                    <p class="help-text mb-0 font-italic">{!!  __('labels.backend.logo.logo_w_note')!!}</p>
                                </div>
                                <div class="col-md-8 offset-md-2">
                                    <div id="logo_w_image_preview" class="d-inline-block p-3 preview">
                                        <img height="50px" src="{{asset('storage/logos/'.config('logo_w_image'))}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                {{ html()->label(__('labels.backend.logo.logo_white'))->class('col-md-2 form-control-label')->for('logo_white_image') }}

                                <div class="col-md-10">
                                    {!! Form::file('logo_white_image', ['class' => 'form-control d-inline-block', 'placeholder' => '', 'data-preview'=>'#logo_white_image_preview', 'id' => 'logo_w_image', 'accept' => 'image/jpeg,image/gif,image/png']) !!}
                                    <p class="help-text mb-0 font-italic">{!!  __('labels.backend.logo.logo_white_note')!!}</p>
                                </div>
                                <div class="col-md-8 offset-md-2">
                                    <div id="logo_white_image_preview" class="d-inline-block p-3 preview">
                                        <img height="50px" src="{{asset('storage/logos/'.config('logo_white_image'))}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                {{ html()->label(__('labels.backend.logo.logo_popup'))->class('col-md-2 form-control-label')->for('logo_white_image') }}

                                <div class="col-md-10">
                                    {!! Form::file('logo_popup', ['class' => 'form-control d-inline-block', 'placeholder' => '', 'data-preview'=>'#logo_popup_preview', 'id' => 'logo_w_image', 'accept' => 'image/jpeg,image/gif,image/png']) !!}
                                    <p class="help-text mb-0 font-italic">{!!  __('labels.backend.logo.logo_popup_note')!!}</p>
                                </div>
                                <div class="col-md-8 offset-md-2">
                                    <div id="logo_popup_preview" class="d-inline-block p-3 preview">
                                        <img height="50px" src="{{asset('storage/logos/'.config('logo_popup'))}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                {{ html()->label(__('labels.backend.logo.favicon'))->class('col-md-2 form-control-label')->for('favicon_image') }}

                                <div class="col-md-10">
                                    {!! Form::file('favicon_image', ['class' => 'form-control d-inline-block', 'placeholder' => '', 'data-preview'=>'#favicon_image_preview', 'accept' => 'image/jpeg,image/gif,image/png']) !!}
                                    <p class="help-text mb-0 font-italic">{!!  __('labels.backend.logo.favicon_note')!!}</p>
                                </div>
                                <div class="col-md-8 offset-md-2">
                                    <div id="favicon_image_preview" class="d-inline-block p-3 preview">
                                        <img height="50px" src="{{asset('storage/logos/'.config('favicon_image'))}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!---Layout Tab--->
                <div id="layout" class="tab-pane container fade">
                    <div class="row mt-4 mb-4">
                        <div class="col">
                            <input type="hidden" id="section_data" name="layout_{{config('theme_layout')}}">
                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.layout_type'))->class('col-md-2 form-control-label')->for('layout_type') }}

                                <div class="col-md-10">
                                    <select class="form-control" id="layout_type" name="layout_type">
                                        <option selected
                                                value="wide-layout">{{__('labels.backend.general_settings.wide')}}</option>
                                        <option value="box-layout">{{__('labels.backend.general_settings.box')}}</option>
                                    </select>
                                    <span class="help-text font-italic">{{__('labels.backend.general_settings.layout_type_note')}}</span>

                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.theme_layout'))->class('col-md-2 form-control-label')->for('theme_layout') }}
                                <div class="col-md-10">
                                    <select class="form-control" id="theme_layout" name="theme_layout">
                                        <option selected
                                                value="1">{{__('labels.backend.general_settings.layout_label')}} 1
                                        </option>
                                        <option value="2">{{__('labels.backend.general_settings.layout_label')}}2
                                        </option>
                                        <option value="3">{{__('labels.backend.general_settings.layout_label')}}3
                                        </option>
                                        <option value="4">{{__('labels.backend.general_settings.layout_label')}}4
                                        </option>
                                    </select>
                                    <span class="help-text font-italic">{{__('labels.backend.general_settings.layout_note')}}</span>
                                    <p id="sections_note"
                                       class="d-none font-weight-bold"> {{__('labels.backend.general_settings.list_update_note')}}</p>

                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row" id="sections">
                                <div class="col-md-10 offset-md-2">
                                    <div class="row">
                                        @foreach($sections as $key=>$item)
                                            <p style="line-height: 35px" class="col-md-4 col-12">
                                                {{ html()->label(html()->checkbox('')->id($key)
                                                   ->checked(($item->status == 1) ? true : false)->class('switch-input')->value(($item->status == 1) ? 1 : 0)

                                             . '<span class="switch-label"></span><span class="switch-handle"></span>')
                                         ->class('switch switch-sm switch-3d switch-primary')
                                     }} <span class="ml-2 title">{{$item->title}}</span>
                                            </p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!---SMTP Tab--->
                <div id="email" class="tab-pane container fade">
                    <div class="row mt-4 mb-4">
                        <div class="col">
                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.email.mail_from_name'))->class('col-md-2 form-control-label')->for('mail_from_name') }}

                                <div class="col-md-10">
                                    {{ html()->text('mail__from__name')
                                        ->class('form-control')
                                        ->placeholder(__('labels.backend.general_settings.email.mail_from_name'))
                                        ->attribute('maxlength', 191)

                                        ->value(config('mail.from.name'))
                                        ->autofocus()
                                        }}
                                    <span class="help-text font-italic">{{__('labels.backend.general_settings.email.mail_from_name_note')}}</span>

                                </div><!--col-->
                            </div><!--form-group-->
                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.email.mail_from_address'))->class('col-md-2 form-control-label')->for('mail_from_address') }}

                                <div class="col-md-10">
                                    {{ html()->text('mail__from__address')
                                        ->class('form-control')
                                        ->placeholder(__('labels.backend.general_settings.email.mail_from_address'))
                                        ->attribute('maxlength', 191)

                                        ->value(config('mail.from.address'))
                                        ->autofocus()
                                        }}
                                    <span class="help-text font-italic">{{__('labels.backend.general_settings.email.mail_from_address_note')}}</span>

                                </div><!--col-->
                            </div><!--form-group-->
                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.email.mail_driver'))->class('col-md-2 form-control-label')->for('mail_driver') }}

                                <div class="col-md-10">
                                    {{ html()->text('mail__driver')
                                        ->class('form-control')
                                        ->placeholder(__('labels.backend.general_settings.email.mail_driver'))
                                        ->attribute('maxlength', 191)

                                        ->value(config('mail.driver'))
                                        }}
                                    <span class="help-text font-italic">{!!   __('labels.backend.general_settings.email.mail_driver_note') !!}</span>

                                </div><!--col-->
                            </div><!--form-group-->
                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.email.mail_host'))->class('col-md-2 form-control-label')->for('mail_host') }}

                                <div class="col-md-10">
                                    {{ html()->text('mail__host')
                                        ->class('form-control')
                                        ->placeholder(__('labels.backend.general_settings.email.mail_driver'))
                                        ->attribute('maxlength', 191)
                                        ->placeholder('Ex. smtp.gmail.com')
                                        ->value(config('mail.host'))
                                        }}
                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.email.mail_port'))->class('col-md-2 form-control-label')->for('mail_port') }}

                                <div class="col-md-10">
                                    {{ html()->text('mail__port')
                                        ->class('form-control')
                                        ->placeholder(__('labels.backend.general_settings.email.mail_port'))
                                        ->attribute('maxlength', 191)
                                        ->placeholder('Ex. 465')
                                        ->value(config('mail.port'))
                                        }}
                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.email.mail_username'))->class('col-md-2 form-control-label')->for('mail_username') }}

                                <div class="col-md-10">
                                    {{ html()->text('mail__username')
                                        ->class('form-control')
                                        ->placeholder(__('labels.backend.general_settings.email.mail_username'))
                                        ->attribute('maxlength', 191)
                                        ->placeholder('Ex. myemail@email.com')
                                        ->value(config('mail.username'))
                                        }}
                                    <span class="help-text font-italic">{!!   __('labels.backend.general_settings.email.mail_username_note') !!}</span>

                                </div><!--col-->
                            </div><!--form-group-->
                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.email.mail_password'))->class('col-md-2 form-control-label')->for('mail_password') }}

                                <div class="col-md-10">
                                    {{ html()->password('mail__password')
                                        ->class('form-control')
                                        ->placeholder(__('labels.backend.general_settings.email.mail_password'))
                                        ->attribute('maxlength', 191)
                                        ->placeholder(__('labels.backend.general_settings.email.mail_password'))
                                        ->value(config('mail.password'))
                                        }}
                                    <span class="help-text font-italic">{!!   __('labels.backend.general_settings.email.mail_password_note') !!}</span>

                                </div><!--col-->
                            </div><!--form-group-->
                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.email.mail_encryption'))->class('col-md-2 form-control-label')->for('mail_encryption') }}

                                <div class="col-md-10">
                                    {{ html()->select('mail__encryption',['tls' => 'tls','ssl' => 'ssl'], config('mail.encryption'))
                                        ->class('form-control')
                                        }}
                                    <span class="help-text font-italic">{!!   __('labels.backend.general_settings.email.mail_encryption_note') !!}</span>

                                </div><!--col-->

                            </div><!--form-group-->
                            <hr>
                            <p class="help-text mb-0">{!!   __('labels.backend.general_settings.email.note') !!}</p>


                        </div>
                    </div>
                </div>

                <!---Payment Configuration Tab--->
                <div id="payment_settings" class="tab-pane container fade">
                    <div class="row mt-4 mb-4">
                        <div class="col">
                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.payment_settings.select_currency'))->class('col-md-3 form-control-label')}}
                                <div class="col-md-9">
                                    <select class="form-control" id="app__currency" name="app__currency">
                                        @foreach(config('currencies') as $currency)
                                            <option @if(config('app.currency') == $currency['short_code']) selected
                                                    @endif value="{{$currency['short_code']}}">
                                                {{$currency['symbol'].' - '.$currency['name']}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.payment_settings.stripe'))->class('col-md-3 form-control-label')->for('services.stripe.active') }}
                                <div class="col-md-9">
                                    <div class="checkbox">
                                        {{ html()->label(
                                                html()->checkbox('services__stripe__active', config('services.stripe.active') ? true : false,1)
                                                      ->class('switch-input')->value(1)
                                                . '<span class="switch-label"></span><span class="switch-handle"></span>')

                                            ->class('switch switch-sm switch-3d switch-primary')
                                        }}
                                        <a class="float-right font-weight-bold font-italic"
                                           href="https://stripe.com/docs/keys"
                                           target="_blank">{{ __('labels.backend.general_settings.payment_settings.how_to_stripe')}}</a>
                                    </div>
                                    <small>
                                        <i> {{ __('labels.backend.general_settings.payment_settings.stripe_note')}}</i>
                                    </small>
                                    <div class="switch-content @if(config('services.stripe.active') == 0 || config('services.stripe.active') == false) d-none @endif">
                                        <br>
                                        <div class="form-group row">
                                            {{ html()->label(__('labels.backend.general_settings.payment_settings.key'))->class('col-md-2 form-control-label')->for('services.stripe.key') }}
                                            <div class="col-md-8 col-xs-12">
                                                {{ html()->text('services__stripe__key')
                                                     ->class('form-control')
                                                     ->value(config('services.stripe.key'))
                                                     }}
                                            </div><!--col-->
                                        </div><!--form-group-->
                                        <div class="form-group row">
                                            {{ html()->label(__('labels.backend.general_settings.payment_settings.secret'))->class('col-md-2 form-control-label')->for('services.stripe.secret') }}
                                            <div class="col-md-8 col-xs-12">
                                                {{ html()->text('services__stripe__secret')
                                                     ->class('form-control')
                                                     ->value(config('services.stripe.secret'))
                                                     }}
                                            </div><!--col-->
                                        </div><!--form-group-->
                                    </div>
                                </div><!--col-->
                            </div><!--form-group-->
                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.payment_settings.paypal'))->class('col-md-3 form-control-label')}}
                                <div class="col-md-9">
                                    <div class="checkbox">
                                        {{ html()->label(
                                                html()->checkbox('paypal__active', config('paypal.active') ? true : false,1)
                                                      ->class('switch-input')->value(1)
                                                . '<span class="switch-label"></span><span class="switch-handle"></span>')

                                            ->class('switch switch-sm switch-3d switch-primary')
                                        }}
                                        <a target="_blank" href="https://developer.paypal.com/developer/applications/"
                                           class="float-right font-italic font-weight-bold">{{ __('labels.backend.general_settings.payment_settings.how_to_paypal')}}</a>
                                    </div>
                                    <small>
                                        <i> {{ __('labels.backend.general_settings.payment_settings.paypal_note')}}</i>
                                    </small>
                                    <div class="switch-content @if(config('paypal.active') == 0 || config('paypal.active') == false) d-none @endif">
                                        <br>
                                        <div class="form-group row">
                                            {{ html()->label(__('labels.backend.general_settings.payment_settings.mode'))->class('col-md-2 form-control-label') }}
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" id="paypal_settings_mode"
                                                        name="paypal__settings__mode">
                                                    <option selected
                                                            value="sandbox">{{__('labels.backend.general_settings.payment_settings.sandbox')}}</option>
                                                    <option value="live">{{__('labels.backend.general_settings.payment_settings.live')}}</option>
                                                </select>
                                                <span class="help-text font-italic">{!!  __('labels.backend.general_settings.payment_settings.mode_note') !!}</span>
                                            </div><!--col-->
                                        </div><!--form-group-->
                                        <div class="form-group row">
                                            {{ html()->label(__('labels.backend.general_settings.payment_settings.client_id'))->class('col-md-2 form-control-label') }}
                                            <div class="col-md-8 col-xs-12">
                                                {{ html()->text('paypal__client_id')
                                                     ->class('form-control')
                                                     ->value(config('paypal.client_id'))
                                                     }}
                                            </div><!--col-->
                                        </div><!--form-group-->
                                        <div class="form-group row">
                                            {{ html()->label(__('labels.backend.general_settings.payment_settings.client_secret'))->class('col-md-2 form-control-label')->for('paypal.paypal.secret') }}
                                            <div class="col-md-8 col-xs-12">
                                                {{ html()->text('paypal__secret')
                                                     ->class('form-control')
                                                     ->value(config('paypal.secret'))
                                                     }}
                                            </div><!--col-->
                                        </div><!--form-group-->
                                    </div>
                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.payment_settings.flutter'))->class('col-md-3 form-control-label')}}
                                <div class="col-md-9">
                                    <div class="checkbox">
                                        {{ html()->label(
                                                html()->checkbox('flutter__active', config('flutter.active') ? true : false,1)
                                                      ->class('switch-input')->value(1)
                                                . '<span class="switch-label"></span><span class="switch-handle"></span>')

                                            ->class('switch switch-sm switch-3d switch-primary')
                                        }}
                                        <a target="_blank" href="https://developer.flutterwave.com/docs/api-keys"
                                           class="float-right font-italic font-weight-bold">{{ __('labels.backend.general_settings.payment_settings.how_to_flutter')}}</a>
                                    </div>
                                    <small>
                                        <i> {{ __('labels.backend.general_settings.payment_settings.flutter_note')}}</i>
                                    </small>
                                    <div class="switch-content @if(config('flutter.active') == 0 || config('flutter.active') == false) d-none @endif">
                                        <br>
                                        <div class="form-group row">
                                            {{ html()->label(__('labels.backend.general_settings.payment_settings.mode'))->class('col-md-2 form-control-label') }}
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" id="rave__env"
                                                        name="rave__env">
                                                    <option selected
                                                            value="staging">{{__('labels.backend.general_settings.payment_settings.sandbox')}}</option>
                                                    <option value="live">{{__('labels.backend.general_settings.payment_settings.live')}}</option>
                                                </select>
                                            </div><!--col-->
                                        </div><!--form-group-->
                                        <div class="form-group row">
                                            {{ html()->label(__('labels.backend.general_settings.payment_settings.key'))->class('col-md-2 form-control-label') }}
                                            <div class="col-md-8 col-xs-12">
                                                {{ html()->text('rave__publicKey')
                                                     ->class('form-control')
                                                     ->value(config('rave.publicKey'))
                                                     }}
                                            </div><!--col-->
                                        </div><!--form-group-->
                                        <div class="form-group row">
                                            {{ html()->label(__('labels.backend.general_settings.payment_settings.secret'))->class('col-md-2 form-control-label')->for('rave__secretKey') }}
                                            <div class="col-md-8 col-xs-12">
                                                {{ html()->text('rave__secretKey')
                                                     ->class('form-control')
                                                     ->value(config('rave.secretKey'))
                                                     }}
                                            </div><!--col-->
                                        </div><!--form-group-->
                                    </div>
                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.payment_settings.instamojo'))->class('col-md-3 form-control-label')}}
                                <div class="col-md-9">
                                    <div class="checkbox">
                                        {{ html()->label(
                                                html()->checkbox('services__instamojo__active', config('services.instamojo.active') ? true : false,1)
                                                      ->class('switch-input')->value(1)
                                                . '<span class="switch-label"></span><span class="switch-handle"></span>')

                                            ->class('switch switch-sm switch-3d switch-primary')
                                        }}
                                    </div>
                                    <small>
                                        <i> {{ __('labels.backend.general_settings.payment_settings.instamojo_note')}}</i>
                                    </small>
                                    <div class="switch-content @if(config('services.instamojo.active') == 0 || config('services.instamojo.active') == false) d-none @endif">
                                        <br>
                                        <div class="form-group row">
                                            {{ html()->label(__('labels.backend.general_settings.payment_settings.mode'))->class('col-md-2 form-control-label') }}
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" id="instamojo_settings_mode"
                                                        name="services__instamojo__mode">
                                                    <option selected
                                                            value="sandbox">{{__('labels.backend.general_settings.payment_settings.sandbox')}}</option>
                                                    <option value="live">{{__('labels.backend.general_settings.payment_settings.live')}}</option>
                                                </select>
                                                <span class="help-text font-italic">{!!  __('labels.backend.general_settings.payment_settings.instamojo_mode_note') !!}</span>
                                            </div><!--col-->
                                        </div><!--form-group-->
                                        <div class="form-group row">
                                            {{ html()->label(__('labels.backend.general_settings.payment_settings.key'))->class('col-md-2 form-control-label') }}
                                            <div class="col-md-8 col-xs-12">
                                                {{ html()->text('services__instamojo__key')
                                                     ->class('form-control')
                                                     ->value(config('services.instamojo.key'))
                                                     }}
                                            </div><!--col-->
                                        </div><!--form-group-->
                                        <div class="form-group row">
                                            {{ html()->label(__('labels.backend.general_settings.payment_settings.instamojo_token'))->class('col-md-2 form-control-label')->for('paypal.paypal.secret') }}
                                            <div class="col-md-8 col-xs-12">
                                                {{ html()->text('services__instamojo__secret')
                                                     ->class('form-control')
                                                     ->value(config('services.instamojo.secret'))
                                                     }}
                                            </div><!--col-->
                                        </div><!--form-group-->
                                    </div>
                                </div><!--col-->
                            </div><!--form-group-->
                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.payment_settings.razorpay'))->class('col-md-3 form-control-label')->for('services.razorpay.active') }}
                                <div class="col-md-9">
                                    <div class="checkbox">
                                        {{ html()->label(
                                                html()->checkbox('services__razorpay__active', config('services.razorpay.active') ? true : false,1)
                                                      ->class('switch-input')->value(1)
                                                . '<span class="switch-label"></span><span class="switch-handle"></span>')

                                            ->class('switch switch-sm switch-3d switch-primary')
                                        }}
                                        <a class="float-right font-weight-bold font-italic"
                                           href="https://dashboard.razorpay.com/"
                                           target="_blank">{{ __('labels.backend.general_settings.payment_settings.how_to_razorpay')}}</a>
                                    </div>
                                    <small>
                                        <i> {{ __('labels.backend.general_settings.payment_settings.razorpay_note')}}</i>
                                    </small>
                                    <div class="switch-content @if(config('services.razorpay.active') == 0 || config('services.razorpay.active') == false) d-none @endif">
                                        <br>
                                        <div class="form-group row">
                                            {{ html()->label(__('labels.backend.general_settings.payment_settings.key'))->class('col-md-2 form-control-label')->for('services.razorpay.key') }}
                                            <div class="col-md-8 col-xs-12">
                                                {{ html()->text('services__razorpay__key')
                                                     ->class('form-control')
                                                     ->value(config('services.razorpay.key'))
                                                     }}
                                            </div><!--col-->
                                        </div><!--form-group-->
                                        <div class="form-group row">
                                            {{ html()->label(__('labels.backend.general_settings.payment_settings.secret'))->class('col-md-2 form-control-label')->for('services.razorpay.secret') }}
                                            <div class="col-md-8 col-xs-12">
                                                {{ html()->text('services__razorpay__secret')
                                                     ->class('form-control')
                                                     ->value(config('services.razorpay.secret'))
                                                     }}
                                            </div><!--col-->
                                        </div><!--form-group-->
                                    </div>
                                </div><!--col-->
                            </div><!--form-group-->
                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.payment_settings.cashfree'))->class('col-md-3 form-control-label')}}
                                <div class="col-md-9">
                                    <div class="checkbox">
                                        {{ html()->label(
                                                html()->checkbox('services__cashfree__active', config('services.cashfree.active') ? true : false,1)
                                                      ->class('switch-input')->value(1)
                                                . '<span class="switch-label"></span><span class="switch-handle"></span>')

                                            ->class('switch switch-sm switch-3d switch-primary')
                                        }}
                                    </div>
                                    <small>
                                        <i> {{ __('labels.backend.general_settings.payment_settings.cashfree_note')}}</i>
                                    </small>
                                    <div class="switch-content @if(config('services.cashfree.active') == 0 || config('services.cashfree.active') == false) d-none @endif">
                                        <br>
                                        <div class="form-group row">
                                            {{ html()->label(__('labels.backend.general_settings.payment_settings.mode'))->class('col-md-2 form-control-label') }}
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" id="cashfree_settings_mode"
                                                        name="services__cashfree__mode">
                                                    <option selected
                                                            value="sandbox">{{__('labels.backend.general_settings.payment_settings.sandbox')}}</option>
                                                    <option value="live">{{__('labels.backend.general_settings.payment_settings.live')}}</option>
                                                </select>
                                                <span class="help-text font-italic">{!!  __('labels.backend.general_settings.payment_settings.cashfree_mode_note') !!}</span>
                                            </div><!--col-->
                                        </div><!--form-group-->
                                        <div class="form-group row">
                                            {{ html()->label(__('labels.backend.general_settings.payment_settings.cashfree_app_id'))->class('col-md-2 form-control-label') }}
                                            <div class="col-md-8 col-xs-12">
                                                {{ html()->text('services__cashfree__app_id')
                                                     ->class('form-control')
                                                     ->value(config('services.cashfree.app_id'))
                                                     }}
                                            </div><!--col-->
                                        </div><!--form-group-->
                                        <div class="form-group row">
                                            {{ html()->label(__('labels.backend.general_settings.payment_settings.cashfree_secret'))->class('col-md-2 form-control-label')->for('paypal.paypal.secret') }}
                                            <div class="col-md-8 col-xs-12">
                                                {{ html()->text('services__cashfree__secret')
                                                     ->class('form-control')
                                                     ->value(config('services.cashfree.secret'))
                                                     }}
                                            </div><!--col-->
                                        </div><!--form-group-->
                                    </div>
                                </div><!--col-->
                            </div><!--form-group-->
                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.payment_settings.payu'))->class('col-md-3 form-control-label')}}
                                <div class="col-md-9">
                                    <div class="checkbox">
                                        {{ html()->label(
                                                html()->checkbox('services__payu__active', config('services.payu.active') ? true : false,1)
                                                      ->class('switch-input')->value(1)
                                                . '<span class="switch-label"></span><span class="switch-handle"></span>')

                                            ->class('switch switch-sm switch-3d switch-primary')
                                        }}
                                        <a class="float-right font-weight-bold font-italic"
                                           href="//www.payumoney.com/merchant-dashboard/#/integration"
                                           target="_blank">{{ __('labels.backend.general_settings.payment_settings.how_to_payu')}}</a>
                                    </div>
                                    <small>
                                        <i> {{ __('labels.backend.general_settings.payment_settings.payu_note')}}</i>
                                    </small>
                                    <div class="switch-content @if(config('services.payu.active') == 0 || config('services.payu.active') == false) d-none @endif">
                                        <br>
                                        <div class="form-group row">
                                            {{ html()->label(__('labels.backend.general_settings.payment_settings.mode'))->class('col-md-2 form-control-label') }}
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" id="payu_settings_mode"
                                                        name="services__payu__mode">
                                                    <option selected
                                                            value="sandbox">{{__('labels.backend.general_settings.payment_settings.sandbox')}}</option>
                                                    <option value="live">{{__('labels.backend.general_settings.payment_settings.live')}}</option>
                                                </select>
                                                <span class="help-text font-italic">{!!  __('labels.backend.general_settings.payment_settings.payu_mode_note') !!}</span>
                                            </div><!--col-->
                                        </div><!--form-group-->
                                        <div class="form-group row">
                                            {{ html()->label(__('labels.backend.general_settings.payment_settings.key'))->class('col-md-2 form-control-label') }}
                                            <div class="col-md-8 col-xs-12">
                                                {{ html()->text('services__payu__key')
                                                     ->class('form-control')
                                                     ->value(config('services.payu.key'))
                                                     }}
                                            </div><!--col-->
                                        </div><!--form-group-->
                                        <div class="form-group row">
                                            {{ html()->label(__('labels.backend.general_settings.payment_settings.payu_salt'))->class('col-md-2 form-control-label')->for('services__payu__salt') }}
                                            <div class="col-md-8 col-xs-12">
                                                {{ html()->text('services__payu__salt')
                                                     ->class('form-control')
                                                     ->value(config('services.payu.salt'))
                                                     }}
                                            </div><!--col-->
                                        </div><!--form-group-->
                                    </div>
                                </div><!--col-->
                            </div><!--form-group-->
                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.payment_settings.offline_mode'))->class('col-md-3 form-control-label')}}
                                <div class="col-md-9">
                                    <div class="checkbox">
                                        {{ html()->label(
                                                html()->checkbox('payment_offline_active', config('payment_offline_active') ? true : false,1)
                                                      ->class('switch-input')->value(1)
                                                . '<span class="switch-label"></span><span class="switch-handle"></span>')

                                            ->class('switch switch-sm switch-3d switch-primary')
                                        }}
                                    </div>
                                    <small>
                                        <i> {{ __('labels.backend.general_settings.payment_settings.offline_mode_note')}}</i>
                                    </small>
                                    {{ html()->textarea('payment_offline_instruction',config('payment_offline_instruction'))
                                            ->class('form-control')->placeholder(__('labels.backend.general_settings.payment_settings.offline_mode_instruction'))
                                        }}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!--Language Tab--->
                <div id="language_settings" class="tab-pane container fade">
                    <div class="row mt-4 mb-4">
                        <div class="col">
                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.language_settings.default_language'))->class('col-md-2 form-control-label')->for('default_language') }}
                                <div class="col-md-10">
                                    <select class="form-control" id="app_locale" name="app__locale">
                                        @foreach($app_locales as $lang)
                                            <option data-display-type="{{$lang->display_type}}"
                                                    @if($lang->is_default == 1) selected
                                                    @endif value="{{$lang->short_name}}">{{(trans('menus.language-picker.langs.'.$lang)) ? trans('menus.language-picker.langs.'.$lang->short_name) : $lang  }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                {{ html()->label(__('labels.backend.general_settings.language_settings.display_type'))->class('col-md-2 form-control-label')->for('display_type') }}

                                <div class="col-md-10">
                                    <select class="form-control" id="app_display_type" name="app__display_type">
                                        <option @if(config('app.display_type') == 'ltr') selected
                                                @endif value="ltr">@lang('labels.backend.general_settings.language_settings.left_to_right')</option>
                                        <option @if(config('app.display_type') == 'rtl') selected
                                                @endif  value="rtl">@lang('labels.backend.general_settings.language_settings.right_to_left')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!---User Registration Settings--->
                <div id="user_registration_settings" class="tab-pane container fade">
                    <div class="row mt-2 mb-4">
                        <div class="col-12 mb-2">
                            <h4>{{__('labels.backend.general_settings.user_registration_settings.desc')}}</h4>
                        </div>
                        <input type="hidden" id="registration_fields" name="registration_fields">

                        <div class="col-lg-9 input-boxes col-12">
                            <div class="form-group">
                                <input type="text" readonly
                                       placeholder="{{__('labels.backend.general_settings.user_registration_settings.fields.first_name')}}"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" readonly
                                       placeholder="{{__('labels.backend.general_settings.user_registration_settings.fields.last_name')}}"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" readonly
                                       placeholder="{{__('labels.backend.general_settings.user_registration_settings.fields.email')}}"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" readonly
                                       placeholder="{{__('labels.backend.general_settings.user_registration_settings.fields.password')}}"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3 border-left col-12">
                            <div class="form-group input-list">
                                <div class="checkbox">
                                    <label><input type="checkbox" checked disabled
                                                  value=""> {{__('labels.backend.general_settings.user_registration_settings.fields.first_name')}}
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" checked disabled
                                                  value=""> {{__('labels.backend.general_settings.user_registration_settings.fields.last_name')}}
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" checked disabled
                                                  value=""> {{__('labels.backend.general_settings.user_registration_settings.fields.email')}}
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" checked disabled
                                                  value=""> {{__('labels.backend.general_settings.user_registration_settings.fields.password')}}
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label><input class="option" type="checkbox" data-name="phone" data-type="number"
                                                  value=""> {{__('labels.backend.general_settings.user_registration_settings.fields.phone')}}
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label><input class="option" type="checkbox" data-name="dob" data-type="date"
                                                  value=""> {{__('labels.backend.general_settings.user_registration_settings.fields.dob')}}
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label><input class="option" type="checkbox" data-name="gender" data-type="radio"
                                                  value=""> {{__('labels.backend.general_settings.user_registration_settings.fields.gender')}}
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label><input class="option" type="checkbox" data-name="address"
                                                  data-type="textarea"
                                                  value=""> {{__('labels.backend.general_settings.user_registration_settings.fields.address')}}
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label><input class="option" type="checkbox" data-name="city" data-type="text"
                                                  value=""> {{__('labels.backend.general_settings.user_registration_settings.fields.city')}}
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label><input class="option" type="checkbox" data-name="pincode" data-type="text"
                                                  value=""> {{__('labels.backend.general_settings.user_registration_settings.fields.pincode')}}
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label><input class="option" type="checkbox" data-name="state" data-type="text"
                                                  value=""> {{__('labels.backend.general_settings.user_registration_settings.fields.state')}}
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label><input class="option" type="checkbox" data-name="country" data-type="text"
                                                  value=""> {{__('labels.backend.general_settings.user_registration_settings.fields.country')}}
                                    </label>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                <!---API Client Settings--->
                <div id="api_client_settings" class="tab-pane container fade">
                    <div class="row mb-4">
                        <div class="col-lg-8 col-12">
                            <h4>{{__('labels.backend.general_settings.api_clients.title')}}</h4>
                        </div>
                        <div class="col-lg-4 col-12">
                            <fieldset>
                                <div class="input-group">
                                    <input type="text" id="api_client_name" class="form-control"
                                           placeholder="{{__('labels.backend.general_settings.api_clients.api_client_name')}}">
                                    <div class="input-group-append" id="button-addon2">
                                        <button class="btn btn-primary generate-client"
                                                type="button">{{__('labels.backend.general_settings.api_clients.generate')}}</button>
                                    </div>
                                </div>
                                <span class="text-danger" id="api_client_name_error"></span>
                            </fieldset>
                        </div>
                        <div class="col-12 mt-2">
                            <p>{!! __('labels.backend.general_settings.api_clients.note') !!}</p>

                            <a target="_blank"
                               href="https://documenter.getpostman.com/view/5183624/SW18uZwk?version=latest"
                               class="btn btn-dark  font-weight-bold text-white">{{__('labels.backend.general_settings.api_clients.developer_manual')}}
                                <i class="fa fa-arrow-right ml-2"></i></a>
                        </div>
                    </div>
                    <div class="row mt-4 mb-4">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered dataTable" id="myTable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('labels.backend.general_settings.api_clients.fields.name')}}</th>
                                        <th>{{__('labels.backend.general_settings.api_clients.fields.id')}}</th>
                                        <th>{{__('labels.backend.general_settings.api_clients.fields.secret')}}</th>
                                        <th>{{__('labels.backend.general_settings.api_clients.fields.status')}}</th>
                                        <th>{{__('labels.backend.general_settings.api_clients.fields.action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($api_clients as $key => $client)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$client->name}}</td>
                                            <td>{{$client->id}}</td>
                                            <td>{{$client->secret}}</td>
                                            <td>{{$client->revoked?__('labels.backend.general_settings.api_clients.revoked'):__('labels.backend.general_settings.api_clients.live')}}</td>
                                            <td>
                                                @if(!$client->revoked)
                                                    <a data-id="{{$client->id}}"
                                                       class="btn btn-sm revoke-api-client btn-danger"
                                                       href="#">{{__('labels.backend.general_settings.api_clients.revoke')}}</a>
                                                @else
                                                    <a data-id="{{$client->id}}"
                                                       class="btn btn-sm btn-success revoke-api-client"
                                                       href="#">{{__('labels.backend.general_settings.api_clients.enable')}}</a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
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
            </div><!--card-->
        </div>
    </div>
    {{ html()->form()->close() }}
@endsection


@push('after-scripts')
    <script src="{{asset('plugins/bootstrap-iconpicker/js/bootstrap-iconpicker.bundle.min.js')}}"></script>
    <script>
        $(document).ready(function () {

                    @if(request()->has('tab'))
            var tab = "{{request('tab')}}";
            $('.nav-tabs a[href="#' + tab + '"]').tab('show');
            @endif

            //========= Initialisation for Iconpicker ===========//
            $('#icon').iconpicker({
                cols: 10,
                icon: 'fab fa-facebook-f',
                iconset: 'fontawesome5',
                labelHeader: '{0} of {1} pages',
                labelFooter: '{0} - {1} of {2} icons',
                placement: 'bottom', // Only in button tag
                rows: 5,
                search: true,
                searchText: 'Search',
                selectedClass: 'btn-success',
                unselectedClass: ''
            });


            //========== Preset theme layout ==============//
            @if(config('theme_layout') != "")
            $('#theme_layout').find('option').removeAttr('selected')
            $('#theme_layout').find('option[value="{{config('theme_layout')}}"]').attr('selected', 'selected');
            @endif


            //============ Preset font color ===============//
            @if(config('font_color') != "")
            $('.color-list').find('li a').removeClass('active');
            $('.color-list').find('li a[data-color="{{config('font_color')}}"]').addClass('active');
            $('#font_color').val("{{config('font_color')}}");
            @endif


            //========= Preset Layout type =================//
            @if(config('layout_type') != "")
            $('#layout_type').find('option').removeAttr('selected')
            $('#layout_type').find('option[value="{{config('layout_type')}}"]').attr('selected', 'selected');
            @endif


            //=========== Preset Counter data =============//
            @if(config('counter') != "")
            @if((int)config('counter') == 1)
            $('.counter-container').removeClass('d-none')
            $('#total_students').val("{{config('total_students')}}");
            $('#total_teachers').val("{{config('total_teachers')}}");
            $('#total_courses').val("{{config('total_courses')}}");
            @else
            $('#counter-container').empty();
            @endif

            @if(config('counter') != "")
            $('.counter-container').removeClass('d-none');
            @endif

            $('#counter').find('option').removeAttr('selected')
            $('#counter').find('option[value="{{config('counter')}}"]').attr('selected', 'selected');
            @endif


            //======== Preset PaymentMode for Paypal =======>
            @if(config('paypal.settings.mode') != "")
            $('#paypal_settings_mode').find('option').removeAttr('selected')
            $('#paypal_settings_mode').find('option[value="{{config('paypal.settings.mode')}}"]').attr('selected', 'selected');
            @endif

            //======== Preset PaymentMode for Instamojo =======>
            @if(config('services.instamojo.mode') != "")
            $('#instamojo_settings_mode').find('option').removeAttr('selected')
            $('#instamojo_settings_mode').find('option[value="{{config('services.instamojo.mode')}}"]').attr('selected', 'selected');
            @endif

            //======== Preset PaymentMode for Cashfree =======>
            @if(config('services.cashfree.mode') != "")
            $('#cashfree_settings_mode').find('option').removeAttr('selected')
            $('#cashfree_settings_mode').find('option[value="{{config('services.cashfree.mode')}}"]').attr('selected', 'selected');
            @endif

            //======== Preset PaymentMode for PayUMoney =======>
            @if(config('services.payu.mode') != "")
            $('#cashfree_settings_mode').find('option').removeAttr('selected')
            $('#cashfree_settings_mode').find('option[value="{{config('services.payu.mode')}}"]').attr('selected', 'selected');
            @endif

            //======== Preset PaymentMode for Flutter =======>
            @if(config('rave.env') != "")
            $('#rave_env').find('option').removeAttr('selected')
            $('#rave_env').find('option[value="{{config('rave.env')}}"]').attr('selected', 'selected');
            @endif


            //============= Font Color selection =================//
            $(document).on('click', '.color-list li', function () {
                $(this).siblings('li').find('a').removeClass('active')
                $(this).find('a').addClass('active');
                $('#font_color').val($(this).find('a').data('color'));
            });


            //============== Captcha status =============//
            $(document).on('click', '#captcha_status', function (e) {
//              e.preventDefault();
                if ($('#captcha-credentials').hasClass('d-none')) {
                    $('#captcha_status').attr('checked', 'checked');
                    $('#captcha-credentials').find('input').attr('required', true);
                    $('#captcha-credentials').removeClass('d-none');
                } else {
                    $('#captcha-credentials').addClass('d-none');
                    $('#captcha-credentials').find('input').attr('required', false);
                }
            });

            //============== One Signal status =============//
            $(document).on('click', '#onesignal_status', function (e) {
//              e.preventDefault();
                if ($('#onesignal-configuration').hasClass('d-none')) {
                    console.log('here')
                    $('#onesignal_status').attr('checked', 'checked');
                    $('#onesignal-configuration').removeClass('d-none').find('textarea').attr('required', true);
                } else {
                    $('#onesignal-configuration').addClass('d-none').find('textarea').attr('required', false);
                }
            });


            //===== Counter value on change ==========//
            $(document).on('change', '#counter', function () {
                if ($(this).val() == 1) {
                    $('.counter-container').empty().removeClass('d-none');
                    var html = "<input class='form-control my-2' type='text' id='total_students' name='total_students' placeholder='" + "{{__('labels.backend.general_settings.total_students')}}" + "'><input type='text' id='total_courses' class='form-control mb-2' name='total_courses' placeholder='" + "{{__('labels.backend.general_settings.total_courses')}}" + "'><input type='text' class='form-control mb-2' id='total_teachers' name='total_teachers' placeholder='" + "{{__('labels.backend.general_settings.total_teachers')}}" + "'>";

                    $('.counter-container').append(html);
                } else {
                    $('.counter-container').addClass('d-none');
                }
            });


            //========== Preview image function on upload =============//
            var previewImage = function (input, block) {
                var fileTypes = ['jpg', 'jpeg', 'png', 'gif'];
                var extension = input.files[0].name.split('.').pop().toLowerCase();
                var isSuccess = fileTypes.indexOf(extension) > -1;

                if (isSuccess) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $(block).find('img').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                } else {
                    alert('Please input valid file!');
                }

            };
            $(document).on('change', 'input[type="file"]', function () {
                previewImage(this, $(this).data('preview'));
            });


            //========== Registration fields status =========//
                    @if(config('registration_fields') != NULL)
            var fields = "{{config('registration_fields')}}";

            fields = JSON.parse(fields.replace(/&quot;/g, '"'));

            $(fields).each(function (key, element) {
                appendElement(element.type, element.name);
                $('.input-list').find('[data-name="' + element.name + '"]').attr('checked', true)

            });

            @endif


            //======= Saving settings for All tabs =================//
            $(document).on('submit', '#general-settings-form', function (e) {
//                e.preventDefault();

                //======Saving Layout sections details=====//
                var sections = $('#sections').find('input[type="checkbox"]');
                var title, name, status;
                var sections_data = {};
                $(sections).each(function () {
                    if ($(this).is(':checked')) {
                        status = 1
                    } else {
                        status = 0
                    }
                    name = $(this).attr('id');
                    title = $(this).parent('label').siblings('.title').html();
                    sections_data[name] = {title: title, status: status}
                });
                $('#section_data').val(JSON.stringify(sections_data));

                //=========Saving Registration fields ===============//
                var inputName, inputType;
                var fieldsData = [];
                var registrationFields = $('.input-list').find('.option:checked');
                $(registrationFields).each(function (key, value) {
                    inputName = $(value).attr('data-name');
                    inputType = $(value).attr('data-type');
                    fieldsData.push({name: inputName, type: inputType});
                });
                $('#registration_fields').val(JSON.stringify(fieldsData));

            });


            //==========Hiding sections on Theme layout option changed ==========//
            $(document).on('change', '#theme_layout', function () {
                var theme_layout = "{{config('theme_layout')}}";
                if ($(this).val() != theme_layout) {
                    $('#sections').addClass('d-none');
                    $('#sections_note').removeClass('d-none')
                } else {
                    $('#sections').removeClass('d-none');
                    $('#sections_note').addClass('d-none')
                }
            });

                    @if(request()->has('tab'))
            var tab = "{{request('tab')}}";
            $('.nav-tabs a[href="#' + tab + '"]').tab('show');
            @endif

        });

        $(document).on('click', '.switch-input', function (e) {
//              e.preventDefault();
            var content = $(this).parents('.checkbox').siblings('.switch-content');
            if (content.hasClass('d-none')) {
                $(this).attr('checked', 'checked');
                content.find('input').attr('required', true);
                content.removeClass('d-none');
            } else {
                content.addClass('d-none');
                content.find('input').attr('required', false);
            }
        })


        //On Default language change update Display type RTL/LTR
        $(document).on('change', '#app_locale', function () {
            var display_type = $(this).find(":selected").data('display-type');
            $('#app_display_type').val(display_type)
        });


        //On click add input list
        $(document).on('click', '.input-list input[type="checkbox"]', function () {

            var html;
            var type = $(this).data('type');
            var name = $(this).data('name');
            var textInputs = ['text', 'date', 'number'];
            if ($(this).is(':checked')) {
                appendElement(type, name)
            } else {
                if ((textInputs.includes(type)) || (type == 'textarea')) {
                    $('.input-boxes').find('[data-name="' + name + '"]').parents('.form-group').remove();
                } else if (type == 'radio') {
                    $('.input-boxes').find('.radiogroup').remove();
                }
            }
        });


        //Revoke App Client Secret
        $(document).on('click', '.revoke-api-client', function () {
            var api_id = $(this).data('id');
            $.ajax({
                url: '{{ route('admin.api-client.status') }}',
                type: 'POST',
                dataType: 'JSON',
                data: {'api_id': api_id, _token: '{{csrf_token()}}'},
                success: function (response) {
                    if (response.status == 'success') {
                        window.location.href = '{{route('admin.general-settings',['tab'=>'api_client_settings'])}}'

                    } else {
                        alert("{{__('labels.backend.general_settings.api_clients.something_went_wrong')}}");
                    }

                }
            })
        });

        $(document).on('click', '.generate-client', function () {
            var api_client_name = $('#api_client_name').val();

            if ($.trim(api_client_name).length > 0) { // zero-length string AFTER a trim
                $.ajax({
                    url: '{{  route('admin.api-client.generate') }}',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {'api_client_name': api_client_name, _token: '{{csrf_token()}}'},
                    success: function (response) {
                        if (response.status == 'success') {
                            window.location.href = '{{route('admin.general-settings',['tab'=>'api_client_settings'])}}'

                        } else {
                            alert("{{__('labels.backend.general_settings.api_clients.something_went_wrong')}}");
                        }

                    }
                })
            } else {
                $('#api_client_name_error').text("{{__('labels.backend.general_settings.api_clients.please_input_api_client_name')}}");
            }

        });

        function appendElement(type, name) {
            var values = "{{json_encode(Lang::get('labels.backend.general_settings.user_registration_settings.fields'))}}";
            values = JSON.parse(values.replace(/&quot;/g, '"'));
            var textInputs = ['text', 'date', 'number'];
            var html;
            if (textInputs.includes(type)) {
                html = "<div class='form-group'>" +
                    "<input type='" + type + "' readonly data-name='" + name + "' placeholder='" + values[name] + "' class='form-control'>" +
                    "</div>";
            } else if (type == 'radio') {
                html = "<div class='form-group radiogroup'>" +
                    "<label class='radio-inline mr-3'><input type='radio' data-name='optradio'> {{__('labels.backend.general_settings.user_registration_settings.fields.male')}} </label>" +
                    "<label class='radio-inline mr-3'><input type='radio' data-name='optradio'> {{__('labels.backend.general_settings.user_registration_settings.fields.female')}}</label>" +
                    "<label class='radio-inline mr-3'><input type='radio' data-name='optradio'> {{__('labels.backend.general_settings.user_registration_settings.fields.other')}}</label>" +
                    "</div>";
            } else if (type == 'textarea') {
                html = "<div class='form-group'>" +
                    "<textarea  readonly data-name='" + name + "' placeholder='" + values[name] + "' class='form-control'></textarea>" +
                    "</div>";
            }
            $('.input-boxes').append(html)
        }


    </script>
@endpush


