<div class="row">
    <div class="col-12 col-lg-12 form-group">
        {!! Form::label('topic', trans('labels.backend.stripe.plan.fields.name').'*', ['class' => 'control-label']) !!}
        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.stripe.plan.fields.name'), 'required' => true]) !!}
    </div>
    <div class="col-12 col-lg-6 form-group">
        {!! Form::label('course', trans('labels.backend.stripe.plan.fields.course'), ['class' => 'control-label']) !!}
        {!! Form::number('course', old('course'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.stripe.plan.fields.course'), 'required' => true, 'readonly' => $plan->id? true: false]) !!}
        <small class="form-text text-muted">@lang('labels.backend.stripe.plan.input_quantity_note')</small>

    </div>
    <div class="col-12 col-lg-6 form-group">
        {!! Form::label('bundle', trans('labels.backend.stripe.plan.fields.bundle'), ['class' => 'control-label']) !!}
        {!! Form::number('bundle', old('bundle'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.stripe.plan.fields.bundle'), 'required' => true, 'readonly' => $plan->id? true: false]) !!}
        <small class="form-text text-muted">@lang('labels.backend.stripe.plan.input_quantity_note')</small>
    </div>

</div>
<div class="row">
    <div class="col-12 col-lg-6 form-group">
        {!! Form::label('amount', trans('labels.backend.stripe.plan.fields.amount').'*', ['class' => 'control-label']) !!}
        {!! Form::text('amount', old('amount'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.stripe.plan.fields.amount'), 'required' => true, 'min' => 10, 'readonly' => $plan->id? true: false]) !!}
    </div>

    <div class="col-12 col-lg-6 form-group">
        {!! Form::label('currency', trans('labels.backend.stripe.plan.fields.currency').'*', ['class' => 'control-label']) !!}
        {!! Form::text('currency', old('currency'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.stripe.plan.fields.currency'), 'required' => true, 'readonly' => $plan->id? true: false]) !!}
        <small class="help-text font-italic">@lang('labels.backend.stripe.plan.stripe_currency_note')</small>
    </div>
    <div class="col-12 col-lg-6 form-group">
        {!! Form::label('interval', trans('labels.backend.stripe.plan.fields.interval').'*', ['class' => 'control-label']) !!}
        {!! Form::select('interval',trans('labels.backend.stripe.plan.interval_type'), old('interval'), ['class' => 'form-control','required' => true, 'readonly' => $plan->id? true: false]) !!}
    </div>
</div>
<div class="row">
    <div class="col-12 form-group">
        {!! Form::label('description', trans('labels.backend.stripe.plan.fields.description'), ['class' => 'control-label']) !!}
        {!! Form::textarea('description', old('description'), ['class' => 'form-control ', 'placeholder' => trans('labels.backend.stripe.plan.fields.description')]) !!}
    </div>
</div>

