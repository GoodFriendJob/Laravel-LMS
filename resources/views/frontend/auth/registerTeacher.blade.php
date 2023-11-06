@extends('frontend'.(session()->get('display_type') == "rtl"?"-rtl":"").'.layouts.app'.config('theme_layout'))

@section('title', app_name() . ' | ' . __('labels.teacher.teacher_register_box_title'))

@section('content')
    <section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
        <div class="blakish-overlay"></div>
        <div class="container">
            <div class="page-breadcrumb-content text-center">
                <div class="page-breadcrumb-title">
                    <h2 class="breadcrumb-head black bold">{{__('labels.teacher.teacher_register_box_title')}}</h2>
                </div>
            </div>
        </div>
    </section>
    <section id="about-page" class="about-page-section pb-0">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card  border-0">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="list-inline list-style-none">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{ html()->form('POST', route('frontend.auth.teacher.register.post'))->acceptsFiles()->class('form-horizontal')->open() }}
                            {!! csrf_field() !!}

                            <div class="row">

                                <div class="col-12  mt-3 mb-2">
                                    <h3>{{ __('validation.attributes.frontend.personal_information') }}</h3>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ html()->label(__('validation.attributes.frontend.first_name'))->for('first_name') }}

                                        {{ html()->text('first_name')
                                            ->class('form-control')
                                            ->placeholder(__('validation.attributes.frontend.first_name'))
                                            ->attribute('maxlength', 191)
                                            ->required() }}
                                    </div><!--form-group-->
                                </div><!--col-->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ html()->label(__('validation.attributes.frontend.last_name'))->for('last_name') }}

                                        {{ html()->text('last_name')
                                            ->class('form-control')
                                            ->placeholder(__('validation.attributes.frontend.last_name'))
                                            ->attribute('maxlength', 191)
                                            ->required() }}
                                    </div><!--form-group-->
                                </div><!--col-->

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        {{ html()->label(__('validation.attributes.frontend.email'))->for('email') }}

                                        {{ html()->email('email')
                                            ->class('form-control')
                                            ->placeholder(__('validation.attributes.frontend.email'))
                                            ->attribute('maxlength', 191)
                                            ->required() }}
                                    </div><!--form-group-->
                                </div><!--col-->

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        {{ html()->label(__('validation.attributes.frontend.password'))->for('password') }}

                                        {{ html()->password('password')
                                            ->class('form-control')
                                            ->placeholder(__('validation.attributes.frontend.password'))
                                            ->required() }}
                                    </div><!--form-group-->
                                </div><!--col-->

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        {{ html()->label(__('validation.attributes.frontend.password_confirmation'))->for('password_confirmation') }}

                                        {{ html()->password('password_confirmation')
                                            ->class('form-control')
                                            ->placeholder(__('validation.attributes.frontend.password_confirmation'))
                                            ->required() }}
                                    </div><!--form-group-->
                                </div><!--col-->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ html()->label(__('labels.backend.teachers.fields.image'))->class('form-control-label')->for('image') }}

                                        {!! Form::file('image', ['class' => 'form-control d-inline-block', 'placeholder' => '']) !!}
                                    </div><!--form-group-->
                                </div><!--col-->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ html()->label(__('labels.backend.general_settings.user_registration_settings.fields.gender'))->for('password_confirmation') }} :
                                        <div class="form-control">
                                            <label class="radio-inline mr-3 mb-0">
                                                <input type="radio" name="gender" value="male"> {{__('validation.attributes.frontend.male')}}
                                            </label>
                                            <label class="radio-inline mr-3 mb-0">
                                                <input type="radio" name="gender" value="female"> {{__('validation.attributes.frontend.female')}}
                                            </label>
                                            <label class="radio-inline mr-3 mb-0">
                                                <input type="radio" name="gender" value="other"> {{__('validation.attributes.frontend.other')}}
                                            </label>
                                        </div>
                                    </div><!--form-group-->
                                </div><!--col-->


                                <div class="col-12  mt-3 mb-2">
                                    <h3>{{ __('validation.attributes.frontend.social_information') }}</h3>
                                </div>

                                <div class="col-md-4 col-12 ">
                                    <div class="form-group">
                                        {{ html()->label(__('labels.teacher.facebook_link')) }}

                                        {{ html()->text('facebook_link')
                                            ->class('form-control')
                                            ->placeholder(__('labels.teacher.facebook_link')) }}
                                    </div><!--form-group-->
                                </div><!--col-->
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        {{ html()->label(__('labels.teacher.twitter_link')) }}

                                        {{ html()->text('twitter_link')
                                            ->class('form-control')
                                            ->placeholder(__('labels.teacher.twitter_link')) }}
                                    </div><!--form-group-->
                                </div><!--col-->

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        {{ html()->label(__('labels.teacher.linkedin_link')) }}

                                        {{ html()->text('linkedin_link')
                                            ->class('form-control')
                                            ->placeholder(__('labels.teacher.linkedin_link')) }}
                                    </div><!--form-group-->
                                </div><!--col-->

                            </div><!--row-->


                            <div class="row">
                                <div class="col-12 mt-3 mb-2">
                                    <h3>{{ __('validation.attributes.frontend.payment_information') }}</h3>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        {{ html()->label(__('labels.teacher.payment_details')) }}

                                        <select class="form-control" name="payment_method" id="payment_method" required>
                                            <option value="bank" {{ old('payment_method') == 'bank'?'selected':'' }}>{{ trans('labels.teacher.bank') }}</option>
                                            <option value="paypal" {{ old('payment_method') == 'paypal'?'selected':'' }}>{{ trans('labels.teacher.paypal') }}</option>
                                        </select>
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->

                            <div class="bank_details">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ html()->label(__('labels.teacher.bank_details.name')) }}

                                            {{ html()->text('bank_name')
                                                ->class('form-control')
                                                ->placeholder(__('labels.teacher.bank_details.name')) }}
                                        </div><!--form-group-->
                                    </div><!--col-->

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ html()->label(__('labels.teacher.bank_details.bank_code')) }}

                                            {{ html()->text('bank_code')
                                                ->class('form-control')
                                                ->placeholder(__('labels.teacher.bank_details.bank_code')) }}
                                        </div><!--form-group-->
                                    </div><!--col-->

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ html()->label(__('labels.teacher.bank_details.account')) }}

                                            {{ html()->text('account_number')
                                                ->class('form-control')
                                                ->placeholder(__('labels.teacher.bank_details.account')) }}
                                        </div><!--form-group-->
                                    </div><!--col-->

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ html()->label(__('labels.teacher.bank_details.holder_name')) }}

                                            {{ html()->text('account_name')
                                                ->class('form-control')
                                                ->placeholder(__('labels.teacher.bank_details.holder_name')) }}
                                        </div><!--form-group-->
                                    </div><!--col-->
                                </div><!--row-->
                            </div>

                            <div class="paypal_details">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            {{ html()->label(__('labels.teacher.paypal_email')) }}

                                            {{ html()->text('paypal_email')
                                                ->class('form-control')
                                                ->placeholder(__('labels.teacher.paypal_email')) }}
                                        </div><!--form-group-->
                                    </div><!--col-->
                                </div><!--row-->
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        {{ html()->label(__('labels.teacher.description')) }}

                                        {{ html()->textarea('description')
                                            ->class('form-control')
                                            ->placeholder(__('labels.teacher.description')) }}
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->


                            <div class="row">
                                <div class="col">
                                    <div class="form-group mb-0 text-center mt-4 clearfix">
                                        <button class="btn btn-info mx-auto btn-lg" type="submit">{{__('labels.frontend.modal.register_now')}}</button>
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->
                            {{ html()->form()->close() }}
                        </div><!-- card-body -->
                    </div><!-- card -->
                </div>
            </div><!-- row -->
        </div>
    </section>
@endsection
@push('after-scripts')
@if(old('payment_method') && old('payment_method') == 'bank')
<script>
    $('.paypal_details').hide();
    $('.bank_details').show();
</script>
@elseif(old('payment_method') && old('payment_method') == 'paypal')
<script>
    $('.paypal_details').show();
    $('.bank_details').hide();
</script>
@else
<script>
    $('.paypal_details').hide();
</script>
@endif
<script>
    $(document).on('change', '#payment_method', function(){
        if($(this).val() === 'bank'){
            $('.paypal_details').hide();
            $('.bank_details').show();
        }else{
            $('.paypal_details').show();
            $('.bank_details').hide();
        }
    });
</script>
@endpush
