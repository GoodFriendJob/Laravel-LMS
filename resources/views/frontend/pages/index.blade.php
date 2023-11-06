@extends('frontend.layouts.app'.config('theme_layout'))

@section('title', ($page->meta_title) ? $page->meta_title : app_name())
@section('meta_description', ($page->meta_description) ? $page->meta_description :'' )
@section('meta_keywords', ($page->meta_keywords) ? $page->meta_keywords : app_name())

@push('after-styles')
    <style>
        .content img {
            margin: 10px;
        }
        .about-page-section ul{
            padding-left: 20px;
            font-size: 20px;
            color: #333333;
            font-weight: 300;
            margin-bottom: 25px;
        }
    </style>
@endpush

@section('content')

    <!-- Start of breadcrumb section
        ============================================= -->
    <section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
        <div class="blakish-overlay"></div>
        <div class="container">
            <div class="page-breadcrumb-content text-center">
                <div class="page-breadcrumb-title">
                    <h2 class="breadcrumb-head black bold">{{env('APP_NAME')}} <span>{{$page->title}}</span></h2>
                </div>
            </div>
        </div>
    </section>
    <!-- End of breadcrumb section
        ============================================= -->

    <section id="about-page" class="about-page-section">
        <div class="container">
            <div class="row">
                <div class="@if($page->sidebar == 1) col-md-9 @else col-md-12 @endif ">
                    <div class="about-us-content-item">
                        @if($page->image != "")
                        <div class="about-gallery w-100 text-center">
                            <div class="about-gallery-img d-inline-block float-none">
                                <img src="{{asset('storage/uploads/'.$page->image)}}" alt="">
                            </div>
                        </div>
                    @endif
                    <!-- /gallery -->

                        <div class="about-text-item">
                            <div class="section-title-2  headline text-left">
                                <h2>{{$page->title}}</h2>
                            </div>
                           {!! $page->content !!}
                        </div>
                        <!-- /about-text -->
                    </div>
                </div>
                @if($page->sidebar == 1)
                    @include('frontend.layouts.partials.right-sidebar')
                @endif
            </div>
        </div>
    </section>
@endsection