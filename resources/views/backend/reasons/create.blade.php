@extends('backend.layouts.app')
@section('title', __('labels.backend.reasons.title').' | '.app_name())

@push('after-styles')
    <link rel="stylesheet" href="{{asset('plugins/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css')}}"/>
@endpush
@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">@lang('labels.backend.reasons.create')</h3>
            <div class="float-right">
                <a href="{{ route('admin.reasons.index') }}"
                   class="btn btn-success">@lang('labels.backend.reasons.view')</a>

            </div>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-12">

                    {!! Form::open(['method' => 'POST', 'route' => ['admin.reasons.store'], 'files' => true,]) !!}

                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-8 form-group">
                            {!! Form::label('title', trans('labels.backend.reasons.fields.title').' *', ['class' => 'control-label']) !!}
                            {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.reasons.fields.title'), 'required' => false]) !!}

                        </div>


                        <div class="col-12 col-lg-4  form-group">

                                {!! Form::label('icon',  trans('labels.backend.reasons.fields.icon'), ['class' => 'control-label  d-block']) !!}
                                <button class="btn  btn-block btn-default border" id="icon" name="icon" title="icon"></button>

                        </div>
                        <div class="col-12 form-group">
                            {!! Form::label('content', trans('labels.backend.reasons.fields.content').' *', ['class' => 'control-label']) !!}
                            {!! Form::textarea('content', old('content'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.reasons.fields.content'), 'required' => false]) !!}

                        </div>

                        <div class="col-12 form-group text-center">

                            {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn mt-auto  btn-danger']) !!}
                        </div>
                    </div>

                    {!! Form::close() !!}

                </div>


            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script src="{{asset('plugins/bootstrap-iconpicker/js/bootstrap-iconpicker.bundle.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('#icon').iconpicker({
                cols: 10,
                icon: 'fas fa-bomb',
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


        })

    </script>
@endpush
