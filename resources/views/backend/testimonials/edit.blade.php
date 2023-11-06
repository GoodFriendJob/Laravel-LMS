@extends('backend.layouts.app')
@section('title', __('labels.backend.testimonials.title').' | '.app_name())

@section('content')

    {!! Form::model($testimonial, ['method' => 'PUT', 'route' => ['admin.testimonials.update', $testimonial->id], 'files' => true,]) !!}

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('labels.backend.questions.edit')</h3>
            <div class="float-right">
                <a href="{{ route('admin.questions.index') }}"
                   class="btn btn-success">@lang('labels.backend.questions.view')</a>
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
    <div class="row">
        <div class="col-12 text-center mb-4">
            {!! Form::submit(trans('strings.backend.general.app_update'), ['class' => 'btn btn-danger']) !!}

        </div>
    </div>
    {!! Form::close() !!}
@stop

