@push('after-styles')
    <style>
        .panel-group .panel-title .btn-link {
            width: 95%;
        }

        .panel-group .panel-title .btn-link:after {
            right: 0px;
        }

        .panel-group .panel-title .btn-link:before {
            right: 0px;
        }
    </style>
@endpush
<section id="faq" class="faq-section faq-secound-home-version faq_3 backgroud-style">
    <div class="container">
        <div class="section-title mb45 headline text-center ">
            <span class="subtitle text-uppercase">{{env('APP_NAME')}} @lang('labels.frontend.layouts.partials.faq')</span>
            <h2>@lang('labels.frontend.layouts.partials.faq_full')</h2>

        </div>

        <div class="faq-tab mb65">
            <div class="faq-tab-ques  ul-li">
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
                    @foreach($faqs as $category)
                        <div id="tab{{$category->id}}" class="tab-content-1 pt35">
                            <div id="accordion" class="panel-group">
                                <div class="row ml-0 mr-0">
                                    @if(count($category->faqs) > 0)
                                        @foreach($category->faqs as $item)
                                            <div class="col-md-6">
                                                <div class="panel">
                                                    <div class="panel-title"
                                                         id="heading{{$category->id.'-'.$item->id}}">
                                                        <h3 class="mb-0">
                                                            <button class="btn btn-link collapsed"
                                                                    data-toggle="collapse"
                                                                    data-target="#collapse{{$category->id.'-'.$item->id}}"
                                                                    aria-expanded="false"
                                                                    aria-controls="collapse{{$category->id.'-'.$item->id}}">
                                                                {{$item->question}}
                                                            </button>
                                                        </h3>
                                                    </div>

                                                    <div id="collapse{{$category->id.'-'.$item->id}}"
                                                         class="collapse "
                                                         aria-labelledby="heading{{$category->id.'-'.$item->id}}"
                                                         data-parent="#accordion">
                                                        <div class="panel-body">
                                                            {{$item->answer}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <!-- end of #accordion -->
                            </div>
                        </div>
                        <!-- #tab1 -->
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
