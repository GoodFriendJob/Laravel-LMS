@extends('frontend.layouts.app'.config('theme_layout'))
@section('content')

    <!-- Start of breadcrumb section
    
        ============================================= -->

    <section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
        <div class="blakish-overlay"></div>
        <div class="container">
            <div class="page-breadcrumb-content text-center">
                <div class="page-breadcrumb-title">
                    <h2 class="breadcrumb-head black bold">@lang('labels.frontend.faq.title')</h2>
                </div>
            </div>
        </div>
    </section>
    <!-- End of breadcrumb section
    
        ============================================= -->


    <!-- Start FAQ section
    
        ============================================= -->

    <section id="faq-page" class="faq-page-section">
        <div class="container">
            <div class="faq-element">
                <div class="row">
                    <div class="col-md-12">
                        <div class="faq-page-tab">
                            <div class="section-title-2 mb65 headline text-left">
                                <h2>@lang('labels.frontend.faq.find')</h2>
                            </div>
                            @if(count($faq_categories) > 0)
                            <div class="faq-tab faq-secound-home-version mb35">
                                <div class="faq-tab-ques  ul-li">
                                    <div class="tab-button text-left mb45">
                                        <ul class="product-tab">
                                            @foreach($faq_categories as $categories)
                                            <li rel="tab{{$categories->id}}">{{$categories->name}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <!-- /tab-head -->

                                    <!-- tab content -->
                                    <div class="tab-container">

                                        <!-- 1st tab -->
                                        @foreach($faq_categories as $category)
                                        <div id="tab{{$category->id}}" class="tab-content-1 pt35">
                                            <div id="accordion" class="panel-group">
                                                <div class="row ml-0 mr-0">
                                                    @if(count($category->faqs) > 0)
                                                        @foreach($category->faqs as $item)
                                                            <div class="col-md-6">
                                                                <div class="panel">
                                                                    <div class="panel-title" id="heading{{$category->id.'-'.$item->id}}">
                                                                        <h3 class="mb-0">
                                                                            <button class="btn btn-link collapsed" data-toggle="collapse"
                                                                                    data-target="#collapse{{$category->id.'-'.$item->id}}"
                                                                                    aria-expanded="false"
                                                                                    aria-controls="collapse{{$category->id.'-'.$item->id}}">
                                                                               {{$item->question}}
                                                                            </button>
                                                                        </h3>
                                                                    </div>

                                                                    <div id="collapse{{$category->id.'-'.$item->id}}" class="collapse "
                                                                         aria-labelledby="heading{{$category->id.'-'.$item->id}}" data-parent="#accordion">
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
                            @else
                              <h3> @lang('labels.general.no_data_available')</h3>
                           @endif

                        </div>

                        <div class="about-btn">
                            <div class="genius-btn gradient-bg text-center text-uppercase ul-li-block bold-font">
                                <a href="{{asset('forums')}}">@lang('labels.frontend.faq.make_question') <i class="fas fa-caret-right"></i></a>
                            </div>
                            <div class="genius-btn gradient-bg text-center text-uppercase ul-li-block bold-font">
                                <a href="{{route('contact')}}">@lang('labels.frontend.faq.contact_us') <i class="fas fa-caret-right"></i></a>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


@endsection

@push('after-scripts')
    <script>
        $('ul.product-tab').find('li:first').addClass('active');
    </script>
@endpush
