@extends('frontend.layouts.app'.config('theme_layout'))
@section('title', trans('labels.frontend.offers.title').' | '.app_name())

@push('after-styles')
    <style>
        .coupon .kanan {
            display: grid;
            border-left: 1px dashed #ddd;
            width: 70% !important;
            position:relative;
        }

        .coupon .kanan .info::after, .coupon .kanan .info::before {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 100%;
        }
        .coupon .kanan .info::before {
            top: -10px;
            left: -10px;
        }
        .coupon{
            background: #eeeff1;
        }

        .coupon .kanan .info::after {
            bottom: -10px;
            left: -10px;
        }
        .coupon .time {
            font-size: 1.6rem;
        }
        .icon-container_box{
            font-size: 50px;
        }

        @media screen and (max-width: 768px){

            .coupon .kanan {
                border:none;
                width: 100% !important;
                position:relative;
            }
            .coupon{
                display: block!important;
                text-align: center;
            }
            .kiri{
                padding-bottom: 0px!important;
            }
            .tengah{
                padding: 10px!important;
            }
            .kanan .info{
                margin-top: 0px!important;
            }
            .coupon .kanan .info::after, .coupon .kanan .info::before {
                content: '';
                position: absolute;
                width: 20px;
                display: none;
                height: 20px;
                background: white;
                border-radius: 100%;
            }

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
                    <h2 class="breadcrumb-head black bold"><span>@lang('labels.frontend.offers.title')</span></h2>
                </div>
            </div>
        </div>
    </section>
    <!-- End of breadcrumb section
        ============================================= -->
    <section id="about-page" class="about-page-section">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    @if(count($coupons) > 0)
                        <div class="row">
                            @foreach($coupons as $coupon)
                                <div class="col-12">
                                    <div class="coupon rounded mb-3 d-flex justify-content-between">
                                        <div class="kiri p-3">
                                            <div class="icon-container ">
                                                <div class="icon-container_box">
                                                    <i class="fa fa-gift" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tengah pl-3 py-3 d-flex w-100 align-self-center justify-content-start">
                                            <div class="d-block w-100">
                                                <h3 class="lead font-weight-bold">{{$coupon->name}} </h3>
                                                <p class="text-muted mb-0">{{$coupon->description}}</p>
                                                <p class="mb-0">@lang('labels.frontend.offers.usage') : @lang('labels.frontend.offers.per_user') {{$coupon->per_user_limit}}</p>
                                                @if($coupon->min_price && $coupon->min_price > 0)
                                                <p class="mb-0">@lang('labels.frontend.offers.minimum_order_amount') {{$coupon->min_price.''.$appCurrency['symbol']}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="kanan d-grid">
                                            <div class="info m-3 d-flex text-center align-self-center">
                                                <div class="w-100">
                                                     <span class="badge badge-success"> @if($coupon->type == 1)
                                                             @lang('labels.backend.coupons.discount_rate')
                                                         @else
                                                             @lang('labels.backend.coupons.flat_rate')
                                                         @endif</span>
                                                    <div class="block">
                                                        <span>@lang('labels.frontend.offers.validity') :
                                                            @if($coupon->expires_at)
                                                                {{  (\Illuminate\Support\Carbon::parse($coupon->expires_at)->diff(\Illuminate\Support\Carbon::now())->days < 1) ? 'today' : \Illuminate\Support\Carbon::parse($coupon->expires_at)->diffInDays(\Illuminate\Support\Carbon::now())}} Days
                                                            @else
                                                                @lang('labels.frontend.offers.unlimited')
                                                            @endif

                                                           </span>
                                                    </div>
                                                    <h4 class="text-bold">{{$coupon->code}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <h2>@lang('labels.frontend.offers.no_offers')</h2>
                    @endif
                </div>
                @include('frontend.layouts.partials.right-sidebar')

            </div>
        </div>
    </section>

@endsection