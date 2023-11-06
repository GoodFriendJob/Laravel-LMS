@extends('backend.layouts.app')
@section('title', __('labels.backend.stripe.plan.edit').' | '.app_name())

@section('content')
    {!! Form::model($plan, ['method' => 'PUT', 'route' => ['admin.stripe.plans.update', ['plan' => $plan]], 'files' => true,]) !!}
    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('labels.backend.stripe.plan.edit')</h3>
            <div class="float-right">
                <a href="{{ route('admin.stripe.plans.index') }}"
                   class="btn btn-success">@lang('labels.backend.stripe.plan.view')</a>
            </div>
        </div>
        <div class="card-body">
            @include('backend.stripe.plan.form')
            <div class="row">
                <div class="col-12  text-center form-group">
                    {!! Form::submit(trans('strings.backend.general.app_update'), ['class' => 'btn  btn-danger']) !!}
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

@stop
