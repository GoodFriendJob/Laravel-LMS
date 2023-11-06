@extends('frontend-rtl.layouts.app'.config('theme_layout'))
@section('title', trans('labels.subscription.payment_status').' | '.app_name())

@push('after-styles')
    <style>
        input[type="radio"] {
            display: inline-block !important;
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
                    <h2 class="breadcrumb-head black bold">@lang('labels.subscription.your_subscription_status')</h2>
                </div>
            </div>
        </div>
    </section>
    <!-- End of breadcrumb section
        ============================================= -->
    <section id="checkout" class="checkout-section">
        <div class="container">
            <div class="section-title mb45 headline text-center">
                @if(session()->has('success'))
                    <h2>  {{session('success')}}</h2>
                    <h4><a href="{{url('/')}}">@lang('labels.subscription.go_to_home')</a></h4>
                @endif
                @if(session()->has('failure'))
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h2>  {{session('failure')}}</h2>
                    <h4><a href="{{route('subscription.plans')}}">@lang('labels.subscription.go_to_plan')</a></h4>
                @endif

            </div>
        </div>
    </section>
@endsection
