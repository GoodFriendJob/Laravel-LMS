<section id="why-choose" class="why-choose-section backgroud-style {{isset($class) ? $class : ''}}">
    <div class="container">
        <div class="section-title mb20 headline text-center ">
            <span class="subtitle text-uppercase">{{env('APP_NAME')}} @lang('labels.frontend.layouts.partials.advantages')</span>
            <h2>Reason <span>Why Choose {{env('APP_NAME')}}.</span></h2>
        </div>
        <div class="extra-features-content">
            <div class="row">
                @foreach($reasons->take(9) as $item)
                    <div class="extra-left-content col-md-4 col-sm-6">
                        <div class="extra-icon-text text-left">
                            <div class="features-icon gradient-bg text-center">
                                <i class="{{$item->icon}}"></i>
                            </div>
                            <div class="features-text">
                                <div class="features-text-title">
                                    <h3>{{$item->title}}</h3>
                                </div>
                                <div class="features-text-dec">
                                    <span>{{$item->content}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
            @endforeach
            <!-- // extra-left-content -->
            </div><!-- /row -->
        </div>
    </div>
</section>
