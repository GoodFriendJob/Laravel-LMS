@extends('backend.layouts.app')
@section('title', __('labels.backend.bundles.title').' | '.app_name())

@section('content')

    {!! Form::open(['method' => 'POST', 'route' => ['admin.bundles.store'], 'files' => true,]) !!}

    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">@lang('labels.backend.bundles.create')</h3>
            <div class="float-right">
                <a href="{{ route('admin.bundles.index') }}"
                   class="btn btn-success">@lang('labels.backend.bundles.view')</a>
            </div>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-10 form-group">
                    {!! Form::label('courses',trans('labels.backend.bundles.fields.courses'), ['class' => 'control-label']) !!}
                    {!! Form::select('courses[]', $courses, old('courses'), ['class' => 'form-control select2 js-example-placeholder-multiple', 'multiple' => 'multiple']) !!}
                </div>
                <div class="col-2 d-flex form-group flex-column">
                    OR <a target="_blank" class="btn btn-primary mt-auto"
                          href="{{route('admin.courses.create')}}">{{trans('labels.backend.bundles.add_courses')}}</a>
                </div>
            </div>
            <div class="row">
                <div class="col-10 form-group">
                    {!! Form::label('category_id',trans('labels.backend.bundles.fields.category'), ['class' => 'control-label']) !!}
                    {!! Form::select('category_id', $categories, old('category_id'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false]) !!}
                </div>
                <div class="col-2 d-flex form-group flex-column">
                    OR <a target="_blank" class="btn btn-primary mt-auto"
                          href="{{route('admin.categories.index').'?create'}}">{{trans('labels.backend.bundles.add_categories')}}</a>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('title', trans('labels.backend.bundles.fields.title').' *', ['class' => 'control-label']) !!}
                    {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.bundles.fields.title'), 'required' => false]) !!}
                </div>
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('slug',  trans('labels.backend.bundles.fields.slug'), ['class' => 'control-label']) !!}
                    {!! Form::text('slug', old('slug'), ['class' => 'form-control', 'placeholder' =>  trans('labels.backend.bundles.slug_placeholder')]) !!}

                </div>
            </div>
            <div class="row">

                <div class="col-12 form-group">
                    {!! Form::label('description',  trans('labels.backend.bundles.fields.description'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('description', old('description'), ['class' => 'form-control ', 'placeholder' => trans('labels.backend.bundles.fields.description')]) !!}

                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-4 form-group">
                    {!! Form::label('price',  trans('labels.backend.bundles.fields.price').' (in '.$appCurrency["symbol"].')', ['class' => 'control-label']) !!}
                    {!! Form::number('price', old('price'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.bundles.fields.price'),'step' => 'any', 'pattern' => "[0-9]"]) !!}
                </div>
                <div class="col-12 col-lg-4 form-group">
                    {!! Form::label('course_image',  trans('labels.backend.bundles.fields.course_image'), ['class' => 'control-label']) !!}
                    {!! Form::file('course_image',  ['class' => 'form-control', 'accept' => 'image/jpeg,image/gif,image/png']) !!}
                    {!! Form::hidden('course_image_max_size', 8) !!}
                    {!! Form::hidden('course_image_max_width', 4000) !!}
                    {!! Form::hidden('course_image_max_height', 4000) !!}

                </div>
                <div class="col-12 col-lg-4  form-group">
                    {!! Form::label('start_date', trans('labels.backend.bundles.fields.start_date').' (yyyy-mm-dd)', ['class' => 'control-label']) !!}
                    {!! Form::text('start_date', old('start_date'), ['class' => 'form-control date','pattern' => '(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))', 'placeholder' => trans('labels.backend.bundles.fields.start_date').' (Ex . 2019-01-01)', 'autocomplete' => 'off']) !!}

                </div>
                @if (Auth::user()->isAdmin())
                <div class="col-12 col-lg-4  form-group">
                    {!! Form::label('expire_at', trans('labels.backend.bundles.fields.expire_at').' (yyyy-mm-dd)', ['class' => 'control-label']) !!}
                    {!! Form::text('expire_at', old('expire_at'), ['class' => 'form-control date','pattern' => '(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))', 'placeholder' => trans('labels.backend.bundles.fields.expire_at').' (Ex . 2019-01-01)', 'autocomplete' => 'off']) !!}

                </div>
                @endif
            </div>
            <div class="row">
                <div class="col-12 form-group">
                    <div class="checkbox d-inline mr-3">
                        {!! Form::hidden('published', 0) !!}
                        {!! Form::checkbox('published', 1, false, []) !!}
                        {!! Form::label('published',  trans('labels.backend.bundles.fields.published'), ['class' => 'checkbox control-label font-weight-bold']) !!}
                    </div>
                    @if (Auth::user()->isAdmin())


                    <div class="checkbox d-inline mr-3">
                        {!! Form::hidden('featured', 0) !!}
                        {!! Form::checkbox('featured', 1, false, []) !!}
                        {!! Form::label('featured',  trans('labels.backend.bundles.fields.featured'), ['class' => 'checkbox control-label font-weight-bold']) !!}
                    </div>

                    <div class="checkbox d-inline mr-3">
                        {!! Form::hidden('trending', 0) !!}
                        {!! Form::checkbox('trending', 1, false, []) !!}
                        {!! Form::label('trending',  trans('labels.backend.bundles.fields.trending'), ['class' => 'checkbox control-label font-weight-bold']) !!}
                    </div>

                    <div class="checkbox d-inline mr-3">
                        {!! Form::hidden('popular', 0) !!}
                        {!! Form::checkbox('popular', 1, false, []) !!}
                        {!! Form::label('popular',  trans('labels.backend.bundles.fields.popular'), ['class' => 'checkbox control-label font-weight-bold']) !!}
                    </div>
                    @endif
                    <div class="checkbox d-inline mr-3">
                        {!! Form::hidden('free', 0) !!}
                        {!! Form::checkbox('free', 1, false, []) !!}
                        {!! Form::label('free',  trans('labels.backend.bundles.fields.free'), ['class' => 'checkbox control-label font-weight-bold']) !!}
                    </div>

                </div>

            </div>

            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('meta_title',trans('labels.backend.bundles.fields.meta_title'), ['class' => 'control-label']) !!}
                    {!! Form::text('meta_title', old('meta_title'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.bundles.fields.meta_title')]) !!}

                </div>
                <div class="col-12 form-group">
                    {!! Form::label('meta_description',trans('labels.backend.bundles.fields.meta_description'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('meta_description', old('meta_description'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.bundles.fields.meta_description')]) !!}
                </div>
                <div class="col-12 form-group">
                    {!! Form::label('meta_keywords',trans('labels.backend.bundles.fields.meta_keywords'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('meta_keywords', old('meta_keywords'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.bundles.fields.meta_keywords')]) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-12  text-center form-group">

                    {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn btn-lg btn-danger']) !!}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}


@stop

@push('after-scripts')
    <script>

        $(document).ready(function () {
            $('#start_date').datepicker({
                autoclose: true,
                dateFormat: "{{ config('app.date_format_js') }}"
            });

            var dateToday = new Date();
            $('#expire_at').datepicker({
                autoclose: true,
                minDate: dateToday,
                dateFormat: "{{ config('app.date_format_js') }}"
            });

            $(".js-example-placeholder-single").select2({
                placeholder: "{{trans('labels.backend.bundles.select_category')}}",
            });

            $(".js-example-placeholder-multiple").select2({
                placeholder: "{{trans('labels.backend.bundles.select_courses')}}",
            });
        });

        var uploadField = $('input[type="file"]');

        $(document).on('change', 'input[type="file"]', function () {
            var $this = $(this);
            $(this.files).each(function (key, value) {
                if (value.size > 5000000) {
                    alert('"' + value.name + '"' + 'exceeds limit of maximum file upload size')
                    $this.val("");
                }
            })
        })

    </script>

@endpush
