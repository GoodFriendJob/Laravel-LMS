@extends('backend.layouts.app')
@section('title', __('labels.backend.tax.title').' | '.app_name())

@push('after-styles')
    <style>
        .form-control-label {
            line-height: 35px;
        }

        .remove {
            float: right;
            color: red;
            font-size: 20px;
            cursor: pointer;
        }

        .error {
            color: red;
        }

    </style>


@endpush
@section('content')
    {{ html()->modelForm($tax, 'PATCH', route('admin.tax.update', $tax->id))->class('form-horizontal')->acceptsFiles()->id('slider-create')->open() }}
    <div class="alert alert-danger d-none" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <div class="error-list">
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">@lang('labels.backend.tax.edit')</h3>
            <div class="float-right">
                <a href="{{ route('admin.tax.index') }}"
                   class="btn btn-success">@lang('labels.backend.tax.view')</a>

            </div>
        </div>
        <div class="card-body">

            <div class="row form-group">
                {{ html()->label(__('labels.backend.tax.fields.name'))->class('col-md-2 form-control-label')->for('first_name') }}

                <div class="col-md-10">
                    {{ html()->text('name')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.tax.fields.name'))
                    ->autofocus()
                    }}

                </div><!--col-->
            </div>

            <div class="row form-group">
                {{ html()->label(__('labels.backend.tax.fields.rate').' (in %)')->class('col-md-2 form-control-label')->for('first_name') }}

                <div class="col-md-10">
                    {{ html()->input('number','rate')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.tax.fields.rate'))
                    }}

                </div><!--col-->
            </div>


            <div class="form-group row justify-content-center">
                <div class="col-4">
                    {{ form_cancel(route('admin.tax.index'), __('buttons.general.cancel')) }}

                    <button class="btn btn-success pull-right" type="submit"
                            id="btn-submit">{{__('buttons.general.crud.update')}}</button>
                </div>
            </div><!--col-->
        </div>
    </div>
    {{ html()->form()->close() }}
@endsection

@push('after-scripts')

@endpush
