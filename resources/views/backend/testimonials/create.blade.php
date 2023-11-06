@extends('backend.layouts.app')
@section('title', __('labels.backend.testimonials.title').' | '.app_name())

@section('content')
    {!! Form::open(['method' => 'POST', 'route' => ['admin.testimonials.store'], 'files' => true,]) !!}

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('labels.backend.testimonials.create')</h3>
            <div class="float-right">
                <a href="{{ route('admin.testimonials.index') }}"
                   class="btn btn-success">@lang('labels.backend.testimonials.view')</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('content', trans('labels.backend.testimonials.fields.name').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control ', 'placeholder' =>  trans('labels.backend.testimonials.fields.name').'*', 'required' => '']) !!}

                </div>
                <div class="col-12 form-group">
                    {!! Form::label('occupation', trans('labels.backend.testimonials.fields.occupation').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('occupation', old('occupation'), ['class' => 'form-control ', 'placeholder' =>  trans('labels.backend.testimonials.fields.occupation').'*', 'required' => '']) !!}

                </div>
                <div class="col-12 form-group">
                    {!! Form::label('content', trans('labels.backend.testimonials.fields.content').'*', ['class' => 'control-label']) !!}
                    {!! Form::textarea('content', old('content'), ['class' => 'form-control ', 'placeholder' =>  trans('labels.backend.testimonials.fields.content').'*', 'required' => '']) !!}

                </div>
            </div>
        </div>
    </div>


    <div class="col-12 text-center">
        {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn btn-danger mb-4 form-group']) !!}
    </div>

    {!! Form::close() !!}
@stop

