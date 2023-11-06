@extends('backend.layouts.app')
@section('title', __('labels.backend.categories.title').' | '.app_name())

@push('after-styles')
    <link rel="stylesheet" href="{{asset('plugins/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css')}}"/>
@endpush
@section('content')
    {!! Form::model($category, ['method' => 'PUT', 'route' => ['admin.categories.update', $category->id], 'files' => true,]) !!}

    <div class="alert alert-danger d-none" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <div class="error-list">
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">@lang('labels.backend.categories.edit')</h3>
            <div class="float-right">
                <a href="{{ route('admin.categories.index') }}"
                   class="btn btn-success">@lang('labels.backend.categories.view')</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
            <div class="col-12 col-lg-4 form-group">
                {!! Form::label('title', trans('labels.backend.categories.fields.name').' *', ['class' => 'control-label']) !!}
                {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Enter Category Name', 'required' => false]) !!}

            </div>


            <div class="col-12 col-lg-2  form-group">

                {!! Form::label('icon',  trans('labels.backend.categories.fields.select_icon'), ['class' => 'control-label  d-block']) !!}
                <button class="btn  btn-block btn-default border" id="icon" name="icon"></button>

            </div>

            <div class="col-12 form-group text-center">

                {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn mt-auto  btn-danger']) !!}
            </div>
        </div>
        </div>
    </div>
    {{ html()->form()->close() }}
@endsection

@push('after-scripts')
    <script src="{{asset('plugins/bootstrap-iconpicker/js/bootstrap-iconpicker.bundle.min.js')}}"></script>

    <script>
        var icon = 'fas fa-bomb';
        @if($category->icon != "")
                icon = "{{$category->icon}}";
        @endif
        $('#icon').iconpicker({
            cols: 10,
            icon: icon,
            iconset: 'fontawesome5',
            labelHeader: '{0} of {1} pages',
            labelFooter: '{0} - {1} of {2} icons',
            placement: 'bottom', // Only in button tag
            rows: 5,
            search: true,
            searchText: 'Search',
            selectedClass: 'btn-success',
            unselectedClass: ''
        });

        $(document).on('change', '#icon_type', function () {

            if ($(this).val() == 1) {
                $('.upload-image-wrapper').parent('.col-12').removeClass('d-none')

                $('.upload-image-wrapper').removeClass('d-none');
                $('.select-icon-wrapper').addClass('d-none')
            } else if ($(this).val() == 2) {
                $('.upload-image-wrapper').parent('.col-12').removeClass('d-none')

                $('.upload-image-wrapper').addClass('d-none');
                $('.select-icon-wrapper').removeClass('d-none')
            } else {
                $('.upload-image-wrapper').parent('.col-12').addClass('d-none')
                $('.upload-image-wrapper').addClass('d-none');
                $('.select-icon-wrapper').addClass('d-none');


            }
        })

    </script>
@endpush


