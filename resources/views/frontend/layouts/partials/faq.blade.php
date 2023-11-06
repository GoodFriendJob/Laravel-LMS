<section id="faq" class="faq-section {{isset($classes) ? $classes : '' }}">
    <div class="container">
        <div class="section-title mb45 headline text-center ">
            <span class="subtitle text-uppercase">{{env('APP_NAME')}} @lang('labels.frontend.layouts.partials.faq')</span>
            <h2>@lang('labels.frontend.layouts.partials.faq_full')</h2>
        </div>
        @if(count($faqs)> 0)

            <div class="faq-tab">
                <div class="faq-tab-ques ul-li">
                    <div class="tab-button text-center mb65 ">
                        <ul class="product-tab">
                            @foreach($faqs as $key=>$faq)
                                <li rel="tab{{$faq->id}}">{{$faq->name}}</li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- /tab-head -->

                    <!-- tab content -->
                    <div class="tab-container">
                    @foreach($faqs as $key=>$faq)
                        <!-- 1st tab -->
                            <div id="tab{{$faq->id}}" class="tab-content-1 pt35">
                                <div class="row">
                                    @foreach($faq->faqs->take(4) as $item)
                                        <div class="col-md-6">
                                            <div class="ques-ans mb45 headline">
                                                <h3> {{$item->question}}</h3>
                                                <p>{{$item->answer}}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- #tab1 -->
                        @endforeach

                    </div>
                    <div class="view-all-btn bold-font {{isset($classes) ? 'text-white' : '' }}">
                        <a href="{{route('faqs')}}">{{trans('labels.frontend.layouts.partials.more_faqs')}} <i class="fas fa-chevron-circle-right"></i></a>
                    </div>
                </div>
            </div>
        @else
            <h4>@lang('labels.general.no_data_available')</h4>
        @endif
    </div>
</section>