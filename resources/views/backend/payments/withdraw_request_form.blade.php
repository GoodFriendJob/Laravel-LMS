@extends('backend.layouts.app')
@section('title', __('labels.backend.payments.add_withdrawal_request').' | '.app_name())

@section('content')
{!! Form::open(['method' => 'POST', 'route' => ['admin.payments.withdraw_store']]) !!}
    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">@lang('labels.backend.payments.add_withdrawal_request')</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6 form-group">
                {!! Form::label('payment_type',trans('labels.backend.payments.fields.payment_type'), ['class' => 'control-label']) !!}
                {!! Form::select('payment_type', $payment_types, old('payment_type'), ['class' => 'form-control select2 js-example-placeholder-multiple']) !!}
                </div>
                <div class="col-6 form-group">
                {!! Form::label('amount',trans('labels.backend.payments.fields.amount'), ['class' => 'control-label']) !!}
                {!! Form::number('amount', old('amount'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.payments.fields.amount'), 'pattern' => "[0-9]", 'min' => '1', 'max' => $total_balance, 'step' => '.01']) !!}
                </div>
            </div>
            <div class="form-group row justify-content-center">
                <div class="col-4">
                    {{ form_cancel(route('admin.payments'), __('buttons.general.cancel')) }}
                    {{ form_submit(__('buttons.general.crud.create')) }}
                </div>
            </div><!--col-->
        </div>
    </div>
@endsection