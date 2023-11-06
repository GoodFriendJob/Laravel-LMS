@extends('backend.layouts.app')
@section('title', __('labels.backend.faqs.title').' | '.app_name())

@section('content')
    {!! Form::open(['method' => 'POST', 'route' => ['admin.faqs.store'], 'files' => true,]) !!}

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('labels.backend.faqs.create')</h3>
            <div class="float-right">
                <a href="{{ route('admin.faqs.index') }}"
                   class="btn btn-success">@lang('labels.backend.faqs.view')</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('category', trans('labels.backend.blogs.fields.category'), ['class' => 'control-label']) !!}
                    {!! Form::select('category', $category,  (request('category')) ? request('category') : old('category'), ['class' => 'form-control select2']) !!}
                </div>
                <div class="col-12 form-group">
                    {!! Form::label('question', trans('labels.backend.faqs.fields.question'), ['class' => 'control-label']) !!}
                    {!! Form::text('question', old('question'), ['class' => 'form-control ', 'placeholder' =>  trans('labels.backend.faqs.fields.question')]) !!}

                </div>
                <div class="col-12 form-group">
                    {!! Form::label('answer', trans('labels.backend.faqs.fields.answer'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('answer', old('answer'), ['class' => 'form-control ', 'placeholder' =>  trans('labels.backend.faqs.fields.answer')]) !!}

                </div>
            </div>
        </div>
    </div>


    <div class="col-12 text-center">
        {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn btn-danger mb-4 form-group']) !!}
    </div>

    {!! Form::close() !!}
@stop

