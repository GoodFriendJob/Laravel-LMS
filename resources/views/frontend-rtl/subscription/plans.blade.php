@extends('frontend-rtl.layouts.app'.config('theme_layout'))

@section('title', 'Subscription Plans | '.app_name())
@section('meta_description', 'subscription plans')
@section('meta_keywords','plans')
@push('after-styles')
    <style>
        .pricing .card {
            border: none;
            border-radius: 1rem;
            transition: all 0.2s;
            box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
        }

        .pricing hr {
            margin: 1.5rem 0;
        }

        .pricing .card-title {
            margin: 0.5rem 0;
            font-size: 0.9rem;
            letter-spacing: .1rem;
            font-weight: bold;
        }

        .pricing .card-price {
            font-size: 3rem;
            margin: 0;
        }

        .pricing .card-price .period {
            font-size: 0.8rem;
        }

        .pricing ul li {
            margin-bottom: 1rem;
        }

        .pricing .text-muted {
            opacity: 0.7;
        }

        .pricing .btn {
            font-size: 80%;
            border-radius: 5rem;
            letter-spacing: .1rem;
            font-weight: bold;
            opacity: 0.7;
            transition: all 0.2s;
        }

        /* Hover Effects on Card */

        @media (min-width: 992px) {
            .pricing .card:hover {
                margin-top: -.25rem;
                margin-bottom: .25rem;
                box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.3);
            }
            .pricing .card:hover .btn {
                opacity: 1;
            }
        }
    </style>
    <script src='https://js.stripe.com/v2/' type='text/javascript'></script>
@endpush

@section('content')
    <section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
        <div class="blakish-overlay"></div>
        <div class="container">
            <div class="page-breadcrumb-content text-center">
                <div class="page-breadcrumb-title">
                    <h2 class="breadcrumb-head black bold">{{env('APP_NAME')}} <span> @lang('labels.subscription.title')</span></h2>
                </div>
            </div>
        </div>
    </section>
    <section class="contact-page-section pricing">
        <div class="container">
            <div class="row">
            @forelse($plans as $plan)
                    <div class="col-lg-4 mt-5">
                        <div class="card mb-5 mb-lg-0">
                            <div class="card-body">
                                <h5 class="card-title text-muted text-uppercase text-center">{{ $plan->name }}</h5>
                                <h6 class="card-price text-center text-uppercase">{{ $plan->currency }} {{ $plan->amount }}<span class="period">/ {{ $plan->interval }}</span></h6>
                                <hr>
                                <ul class="fa-ul">
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span><strong>{{ trans_choice('labels.subscription.quantity', $plan->quantity, ['quantity' => $plan->quantity]) }}</strong></li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>{{ trans_choice('labels.subscription.course', $plan->course, ['quantity' => $plan->course]) }}</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>{{ trans_choice('labels.subscription.bundle', $plan->bundle, ['quantity' => $plan->bundle]) }}</li>

                                    @if($plan->trial_period_days)
                                        <li><span class="fa-li"><i class="fas fa-check"></i></span>{{ trans_choice('labels.subscription.trial_period', $plan->bundle, ['days' => $plan->trial_period_days]) }}</li>
                                    @endif
                                </ul>
                                @if(auth()->check())
                                    @if(auth()->user()->subscribed('default'))
                                        @if(auth()->user()->onPlan($plan->plan_id) && auth()->user()->subscription('default')->ends_at == null)
                                        <a href="#" class="btn btn-block text-white genius-btn mt25 gradient-bg text-center text-uppercase  bold-font">@lang('labels.subscription.already_subscribe')</a>
                                        @else
                                            <a href="{{ route('subscription.form', ['plan' => $plan,'name' => $plan->name]) }}" class="btn btn-block text-white genius-btn mt25 gradient-bg text-center text-uppercase  bold-font">@lang('labels.subscription.button')</a>
                                        @endif
                                    @else
                                        <a href="{{ route('subscription.form', ['plan' => $plan,'name' => $plan->name]) }}" class="btn btn-block text-white genius-btn mt25 gradient-bg text-center text-uppercase  bold-font">@lang('labels.subscription.button')</a>
                                    @endif
                                @else
                                <a id="openLoginModal" data-target="#myModal" href="#" class="btn btn-block text-white genius-btn mt25 gradient-bg text-center text-uppercase  bold-font">@lang('labels.subscription.button')</a>
                                @endif
                            </div>
                        </div>
                    </div>
            @empty
            @endforelse
            </div>
        </div>
    </section>
@endsection
@push('after-scripts')
    <script type="text/javascript" src="{{asset('js/stripe-form.js')}}"></script>
@endpush
