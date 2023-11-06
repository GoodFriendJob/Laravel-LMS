@extends('backend.layouts.app')

@section('title', __('labels.backend.faqs.title').' | '.app_name())

@section('content')

    {!! Form::model($faq, ['method' => 'PUT', 'route' => ['admin.faqs.update', $faq->id], 'files' => true,]) !!}

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('labels.backend.faqs.edit')</h3>
            <div class="float-right">
                <a href="{{ route('admin.faqs.index') }}"
                   class="btn btn-success">@lang('labels.backend.faqs.view')</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('category', trans('labels.backend.blogs.fields.category'), ['class' => 'control-label']) !!}
                    {!! Form::select('category', $category,  $faq->category_id, ['class' => 'form-control select2']) !!}
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
    <div class="row">
        <div class="col-12 text-center mb-4">
            {!! Form::submit(trans('strings.backend.general.app_update'), ['class' => 'btn btn-danger']) !!}

        </div>
    </div>
    {!! Form::close() !!}
@stop

