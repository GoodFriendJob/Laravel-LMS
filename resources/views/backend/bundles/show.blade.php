@extends('backend.layouts.app')
@section('title', __('labels.backend.bundles.title').' | '.app_name())

@push('after-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/amigo-sorter/css/theme-default.css')}}">
    <style>
        ul.sorter > span {
            display: inline-block;
            width: 100%;
            height: 100%;
            background: #f5f5f5;
            color: #333333;
            border: 1px solid #cccccc;
            border-radius: 6px;
            padding: 0px;
        }

        ul.sorter li > span .title {
            padding-left: 15px;
            width: 70%;
        }

        ul.sorter li > span .btn {
            width: 20%;
        }

        @media screen and (max-width: 768px) {

            ul.sorter li > span .btn {
                width: 30%;
            }

            ul.sorter li > span .title {
                padding-left: 15px;
                width: 70%;
                float: left;
                margin: 0 !important;
            }

        }


    </style>
@endpush

@section('content')

    <div class="card">

        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('labels.backend.bundles.title')</h3>
            <a href="{{route('admin.bundles.index')}}" class="btn btn-primary float-right">@lang('labels.general.back')</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('labels.backend.bundles.fields.title')</th>
                            <td>
                                @if($bundle->published == 1)
                                    <a class="text-decoration-none"  target="_blank"
                                       href="{{ route('bundles.show', [$bundle->slug]) }}">{{ $bundle->title }}</a>
                                @else
                                    {{ $bundle->title }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.bundles.fields.slug')</th>
                            <td>{{ $bundle->slug }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.bundles.fields.category')</th>
                            <td>{{ $bundle->category->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.bundles.fields.courses')</th>
                            <td>
                                <ol class="pl-3 mb-0">
                                    @foreach($bundle->courses as $course)
                                        <li>
                                            <a target="_blank" class="text-decoration-none" href="{{route('courses.show',['slug' => $course->slug])}}">{{$course->title}}</a>
                                        </li>
                                    @endforeach
                                </ol>
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.bundles.fields.description')</th>
                            <td>{!! $bundle->description !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.bundles.fields.price')</th>
                            <td>{{ ($bundle->free == 1) ? trans('labels.backend.bundles.fields.free') : $bundle->price .' '.$appCurrency['symbol'] }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.bundles.fields.course_image')</th>
                            <td>@if($bundle->course_image)<a
                                        href="{{ asset('storage/uploads/' . $bundle->course_image) }}"
                                        target="_blank"><img
                                            src="{{ asset('storage/uploads/' . $bundle->course_image) }}"
                                            height="50px"/></a>@endif</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.bundles.fields.start_date')</th>
                            <td>{{ $bundle->start_date }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.bundles.fields.expire_at')</th>
                            <td>{{ $bundle->expire_at }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.bundles.fields.published')</th>
                            <td>{{ Form::checkbox("published", 1, $bundle->published == 1 ? true : false, ["disabled"]) }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.bundles.fields.meta_title')</th>
                            <td>{{ $bundle->meta_title }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.bundles.fields.meta_description')</th>
                            <td>{{ $bundle->meta_description }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.bundles.fields.meta_keywords')</th>
                            <td>{{ $bundle->meta_keywords }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
        </div>
    </div>
@stop

@push('after-scripts')
@endpush
