<!-- Start of footer area
    ============================================= -->
@php
    $footer_data = json_decode(config('footer_data'));
@endphp

@if($footer_data != "")
<footer>
    <section id="footer-area" class="footer-area-section">
        <div class="container">
            <div class="footer-content pb10">
                <div class="row">
                    <div class="col-md-4">
                        <div class="footer-widget ">
                            <div class="footer-logo mb35">
                                <img src="{{asset("storage/logos/".config('logo_b_image'))}}" alt="logo">
                            </div>
                            @if($footer_data->short_description->status == 1)
                                <div class="footer-about-text">
                                    <p>{!! $footer_data->short_description->text !!} </p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            @if($footer_data->section1->status == 1)
                                @php
                                    $section_data = section_filter($footer_data->section1)
                                @endphp

                                @include('frontend.layouts.partials.footer_section',['section_data' => $section_data])
                            @endif

                            @if($footer_data->section2->status == 1)
                                @php
                                    $section_data = section_filter($footer_data->section2)
                                @endphp

                                @include('frontend.layouts.partials.footer_section',['section_data' => $section_data])
                            @endif

                            @if($footer_data->section3->status == 1)
                                @php
                                    $section_data = section_filter($footer_data->section3)
                                @endphp

                                @include('frontend.layouts.partials.footer_section',['section_data' => $section_data])
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- /footer-widget-content -->
            <div class="footer-social-subscribe mb65">
                <div class="row">
                    @if(($footer_data->social_links->status == 1) && (count($footer_data->social_links->links) > 0))
                        <div class="col-md-4">
                            <div class="footer-social ul-li ">
                                <h2 class="widget-title">@lang('labels.frontend.layouts.partials.social_network')</h2>
                                <ul>
                                    @foreach($footer_data->social_links->links as $item)
                                        <li><a href="{{$item->link}}"><i class="{{$item->icon}}"></i></a></li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    @endif

                    @if($footer_data->newsletter_form->status == 1)
                        <div class="col-md-8">
                            <div class="subscribe-form ml-0 ">
                                <h2 class="widget-title">@lang('labels.frontend.layouts.partials.subscribe_newsletter')</h2>

                                <div class="subs-form relative-position">
                                    <form action="{{route("subscribe")}}" method="post">
                                        @csrf
                                        <input class="email" required name="subs_email" type="email" placeholder="@lang('labels.frontend.layouts.partials.email_address').">
                                        <div class="nws-button text-center  gradient-bg text-uppercase">
                                            <button type="submit" value="Submit">@lang('labels.frontend.layouts.partials.subscribe_now')</button>
                                        </div>
                                        @if($errors->has('email'))
                                            <p class="text-danger text-left">{{$errors->first('email')}}</p>
                                        @endif
                                    </form>

                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if($footer_data->bottom_footer->status == 1)
            <div class="copy-right-menu">
                <div class="row">
                    @if($footer_data->copyright_text->status == 1)
                    <div class="col-md-6">
                        <div class="copy-right-text">
                            <p>Powered By <a href="https://www.neonlms.com/" target="_blank" class="mr-4"> NeonLMS</a>  {!!  $footer_data->copyright_text->text !!}</p>
                        </div>
                    </div>
                    @endif
                    @if(($footer_data->bottom_footer_links->status == 1) && (count($footer_data->bottom_footer_links->links) > 0))
                    <div class="col-md-6">
                        <div class="copy-right-menu-item float-right ul-li">
                            <ul>
                                @foreach($footer_data->bottom_footer_links->links as $item)
                                <li><a href="{{$item->link}}">{{$item->label}}</a></li>
                                @endforeach
                                @if(config('show_offers'))
                                    <li><a href="{{route('frontend.offers')}}">@lang('labels.frontend.layouts.partials.offers')</a> </li>
                                @endif
                                <li><a href="{{route('frontend.certificates.getVerificationForm')}}">@lang('labels.frontend.layouts.partials.certificate_verification')</a></li>
                            </ul>
                        </div>
                    </div>
                     @endif
                </div>
            </div>
            @endif
        </div>
    </section>
</footer>
@endif
<!-- End of footer area
============================================= -->

@push('after-scripts')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script>
        window.addEventListener('load', function () {
            alertify.set('notifier', 'position', 'top-right');
        });

        function showNotice(type, message) {
            var alertifyFunctions = {
                'success': alertify.success,
                'error': alertify.error,
                'info': alertify.message,
                'warning': alertify.warning
            };

            alertifyFunctions[type](message, 10);
        }
    </script>
    <script src="{{ asset('js/wishlist.js') }}"></script>
    <style>
        .alertify-notifier .ajs-message{
            color: #ffffff;
        }
    </style>
@endpush
