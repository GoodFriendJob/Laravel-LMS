@extends('backend.layouts.app')
@section('title', __('labels.backend.blogs.title').' | '.app_name())

@push('after-styles')
    <style>
        .blog-detail-content p img{
            margin: 2px;
        }
        .label{
            margin-bottom: 5px;
            display: inline-block;
            border-radius: 0!important;
            font-size: 0.9em;
        }
    </style>
@endpush

@section('content')


    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('labels.backend.blogs.view')</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">

                        <tr>
                            <th>@lang('labels.backend.blogs.fields.title')</th>
                            <td>{{ $blog->title }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.blogs.fields.slug')</th>
                            <td>{{ $blog->slug }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.blogs.fields.featured_image')</th>
                            <td>@if($blog->image)<a href="{{ asset('storage/uploads/' . $blog->image) }}" target="_blank"><img src="{{ asset('storage/uploads/' . $blog->image) }}" height="100px"/></a>@endif</td>
                        </tr>

                        <tr>
                            <th>@lang('labels.backend.blogs.fields.content')</th>
                            <td>{!! $blog->content !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.blogs.fields.tags')</th>
                            <td>{{ $blog->tags->pluck('name')->implode(',') }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.blogs.fields.meta_title')</th>
                            <td>{{ $blog->meta_title }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.blogs.fields.meta_description')</th>
                            <td>{{ $blog->meta_description }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.blogs.fields.meta_keywords')</th>
                            <td>{{ $blog->meta_keywords }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.blogs.fields.created_at')</th>
                            <td>{{ $blog->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->

            <!-- Tab panes -->


            <a href="{{ route('admin.blogs.index') }}"
               class="btn btn-default border">@lang('strings.backend.general.app_back_to_list')</a>
        </div>
    </div>

@endsection

@push('after-scripts')
@endpush