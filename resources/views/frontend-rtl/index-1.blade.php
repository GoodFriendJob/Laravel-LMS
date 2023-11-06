@extends('frontend-rtl.layouts.app'.config('theme_layout'))

@section('title', trans('labels.frontend.home.title').' | '.app_name())
@section('meta_description', '')
@section('meta_keywords','')


@push('after-styles')
    <style>
        /*.address-details.ul-li-block{*/
        /*line-height: 60px;*/
        /*}*/
        .teacher-img-content .teacher-social-name{
            max-width: 67px;
        }
        .my-alert{
            position: absolute;
            z-index: 10;
            left: 0;
            right: 0;
            top: 25%;
            width: 50%;
            margin: auto;
            display: inline-block;
        }
    </style>
@endpush

@section('content')

    <!-- Start of slider section
            ============================================= -->
    @if(session()->has('alert'))
    <div class="alert alert-light alert-dismissible fade my-alert show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>{{session('alert')}}</strong>
    </div>
    @endif

    <!-- Start of slider section
          ============================================= -->
    @include('frontend-rtl.layouts.partials.slider')
    <!-- End of slider section
          ============================================= -->

    @if($sections->search_section->status == 1)

        <section id="search-course" class="search-course-section">
            <div class="container">
                <div class="section-title mb20 headline text-center ">
                    <span class="subtitle text-uppercase">@lang('labels.frontend.home.learn_new_skills')</span>
                    <h2>@lang('labels.frontend.home.search_courses')</h2>
                </div>
                <div class="search-course mb30 relative-position ">
                    <form action="{{route('search')}}" method="get">

                        <div class="input-group search-group">
                            <input class="course" name="q" type="text"
                                   placeholder="@lang('labels.frontend.home.search_course_placeholder')">
                            <select name="category" class="select form-control">
                                @if(count($categories) > 0 )
                                    <option value="">@lang('labels.frontend.course.select_category')</option>
                                    @foreach($categories as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>

                                    @endforeach
                                @else
                                    <option>>@lang('labels.frontend.home.no_data_available')</option>
                                @endif

                            </select>
                            <div class="nws-button position-relative text-center  gradient-bg text-capitalize">
                                <button type="submit"
                                        value="Submit">@lang('labels.frontend.home.search_course')</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="search-counter-up">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <div class="counter-icon-number ">
                                <div class="counter-icon">
                                    <i class="text-gradiant flaticon-graduation-hat"></i>
                                </div>
                                <div class="counter-number">
                                    <span class=" bold-font">{{$total_students}}</span>
                                    <p>@lang('labels.frontend.home.students_enrolled')</p>
                                </div>
                            </div>
                        </div>
                        <!-- /counter -->

                        <div class="col-md-4 col-sm-4">
                            <div class="counter-icon-number ">
                                <div class="counter-icon">
                                    <i class="text-gradiant flaticon-book"></i>
                                </div>
                                <div class="counter-number">
                                    <span class=" bold-font">{{$total_courses}}</span>
                                    <p>@lang('labels.frontend.home.online_available_courses')</p>
                                </div>
                            </div>
                        </div>
                        <!-- /counter -->


                        <div class="col-md-4 col-sm-4">
                            <div class="counter-icon-number ">
                                <div class="counter-icon">
                                    <i class="text-gradiant flaticon-group"></i>
                                </div>
                                <div class="counter-number">
                                    <span class=" bold-font">{{$total_teachers}}</span>
                                    <p>@lang('labels.frontend.home.teachers')</p>
                                </div>
                            </div>
                        </div>
                        <!-- /counter -->
                    </div>
                </div>
            </div>
        </section>
        <!-- End of Search Courses
            ============================================= -->
    @endif


    @if($sections->popular_courses->status == 1)
        @include('frontend.layouts.partials.popular_courses')
    @endif

    @if(($sections->reasons->status != 0) || ($sections->testimonial->status != 0))
        <!-- Start of why choose us section
        ============================================= -->
        <section id="why-choose-us" class="why-choose-us-section">
            <div class="jarallax  backgroud-style">
                <div class="container">
                    @if($sections->reasons->status == 1)

                        <div class="section-title mb20 headline text-center ">
                            <span class="subtitle text-uppercase">{{env('APP_NAME')}} @lang('labels.frontend.layouts.partials.advantages')</span>
                            <h2>@lang('labels.frontend.layouts.partials.why_choose') <span>{{app_name()}}</span></h2>
                        </div>
                        @if($reasons->count() > 0)
                            <div id="service-slide-item" class="service-slide">
                                @foreach($reasons as $item)
                                    <div class="service-text-icon ">

                                        <div class="service-icon float-left">
                                            <i class="text-gradiant {{$item->icon}}"></i>
                                        </div>
                                        <div class="service-text">
                                            <h3 class="bold-font">{{$item->title}}</h3>
                                            <p>{{$item->content}}.</p>
                                        </div>
                                    </div>

                                @endforeach

                            </div>
                        @endif
                    @endif
                <!-- /service-slide -->
                    @if($sections->testimonial->status == 1)
                        <div class="testimonial-slide">
                            <div class="section-title-2 mb65 headline text-left ">
                                <h2>@lang('labels.frontend.layouts.partials.students_testimonial')</h2>
                            </div>
                            @if($testimonials->count() > 0)
                                <div id="testimonial-slide-item" class="testimonial-slide-area">
                                    @foreach($testimonials as $item)
                                        <div class="student-qoute ">
                                            <p>{{$item->content}}</p>
                                            <div class="student-name-designation">
                                                <span class="st-name bold-font">{{$item->name}} </span>
                                                <span class="st-designation">{{$item->occupation}}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <h4>@lang('labels.general.no_data_available')</h4>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </section>
        <!-- End of why choose us section
            ============================================= -->
    @endif

    @if($sections->latest_news->status == 1)
        <!-- Start latest section
        ============================================= -->
        @include('frontend.layouts.partials.latest_news')
        <!-- End latest section
            ============================================= -->
    @endif


    @if($sections->sponsors->status == 1)
        @if(count($sponsors) > 0 )
            <!-- Start of sponsor section
        ============================================= -->
            <section id="sponsor" class="sponsor-section">
                <div class="container">
                    <div class="section-title-2 mb65 headline text-left ">
                        <h2>{{env('APP_NAME')}} <span>@lang('labels.frontend.layouts.partials.sponsors')</span></h2>
                    </div>

                    <div class="sponsor-item sponsor-1 text-center">
                        @foreach($sponsors as $sponsor)
                            <div class="sponsor-pic text-center">
                                <a href="{{ ($sponsor->link != "") ? $sponsor->link : '#' }}">
                                    <img src={{asset("storage/uploads/".$sponsor->logo)}} alt="{{$sponsor->name}}">
                                </a>

                            </div>
                        @endforeach

                    </div>
                </div>
            </section>
            <!-- End of sponsor section
       ============================================= -->
        @endif
    @endif


    @if($sections->featured_courses->status == 1)
        <!-- Start of best course
        ============================================= -->
        @include('frontend.layouts.partials.browse_courses')
        <!-- End of best course
            ============================================= -->
    @endif


    @if($sections->teachers->status == 1)
        <!-- Start of course teacher
        ============================================= -->
        <section id="course-teacher" class="course-teacher-section">
            <div class="jarallax">
                <div class="container">
                    <div class="section-title mb20 headline text-center ">
                        <span class="subtitle text-uppercase">@lang('labels.frontend.home.our_professionals')</span>
                        <h2>{{env('APP_NAME')}} <span>@lang('labels.frontend.home.teachers').</span></h2>
                    </div>

                    <div class="teacher-list">
                        <div class="row justify-content-center">
                            <!-- /teacher -->
                            @if(count($teachers)> 0)
                                @foreach($teachers as $item)
                                    <div class="col-md-3">
                                        <div class="teacher-img-content ">
                                            <div class="teacher-cntent">
                                                <div class="teacher-social-name ul-li-block">
                                                    <ul>
                                                        <li><a href="{{'mailto:'.$item->email}}"><i class="fa fa-envelope"></i></a></li>
                                                        <li><a href="{{route('admin.messages',['teacher_id'=>$item->id])}}"><i class="fa fa-comments"></i></a></li>
                                                    </ul>
                                                    <div class="teacher-name">
                                                        <span>{{$item->full_name}}</span>
                                                    </div>
                                                </div>
                                                <div class="teacher-img-category">
                                                    <div class="teacher-img">
                                                        <img src="{{$item->picture}}" style="height: 100%" alt="">
                                                        {{--<div class="course-price text-uppercase text-center gradient-bg">--}}
                                                        {{--<span>Featured</span>--}}
                                                        {{--</div>--}}
                                                    </div>
                                                    {{--<div class="teacher-category float-right">--}}
                                                    {{--<span class="st-name">{{$item->name}} </span>--}}
                                                    {{--</div>--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="genius-btn gradient-bg text-center text-uppercase ul-li-block bold-font ">
                            <a href="{{route('teachers.index')}}">@lang('labels.frontend.home.all_teachers')<i class="fas fa-caret-left"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End of course teacher
            ============================================= -->
    @endif


    @if($sections->faq->status == 1)
        <!-- Start FAQ section
        ============================================= -->
        @include('frontend.layouts.partials.faq')
        <!-- End FAQ section
            ============================================= -->
    @endif


    @if($sections->course_by_category->status == 1)
        <!-- Start Course category
        ============================================= -->
        @include('frontend.layouts.partials.course_by_category')
        <!-- End Course category
            ============================================= -->
    @endif


    @if($sections->contact_us->status == 1)
        <!-- Start of contact area
        ============================================= -->
        @include('frontend.layouts.partials.contact_area')
        <!-- End of contact area
            ============================================= -->
    @endif


@endsection

@push('after-scripts')
    <script>
        $('ul.product-tab').find('li:first').addClass('active');
    </script>
@endpush
