@extends('backend.layouts.app')

@section('title', __('labels.backend.stripe.plan.title').' | '.app_name())

@section('content')

    {!! Form::open(['method' => 'POST', 'route' => ['admin.stripe.plans.store'], 'files' => true]) !!}
    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('labels.backend.stripe.plan.create')</h3>
            <div class="float-right">
                <a href="{{ route('admin.stripe.plans.index') }}"
                   class="btn btn-success">@lang('labels.backend.stripe.plan.view')</a>
            </div>
        </div>
        <div class="card-body">
            @include('backend.stripe.plan.form',['plan' => optional()])
            <div class="row">
                <div class="col-12  text-center form-group">
                    {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn  btn-danger']) !!}
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

@stop
