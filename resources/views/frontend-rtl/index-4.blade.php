@extends('frontend-rtl.layouts.app'.config('theme_layout'))

@section('title', trans('labels.frontend.home.title').' | '.app_name())
@section('meta_description', '')
@section('meta_keywords','')

@push("after-styles")
    <style>
        #search-course-2 {
            padding-bottom: 125px;
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
        #search-course .search-group select{
            background-color: white!important;
        }
        .teacher-img-content img{
            height: 100%;
            object-fit: cover;
        }
    </style>
@endpush
@section('content')

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


    @if($sections->counters->status == 1)
        <!-- Start of Search Courses
    ============================================= -->
        <section id="search-course" class="search-course-section search-course-third">
            <div class="container">
                <div class="search-counter-up">
                    <div class="version-four">
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <div class="counter-icon-number">
                                    <div class="counter-icon">
                                        <i class="text-gradiant flaticon-graduation-hat"></i>
                                    </div>
                                    <div class="counter-number">
                                        <span class="bold-font">{{$total_students}}</span>
                                        <p>@lang('labels.frontend.home.students_enrolled')</p>
                                    </div>
                                </div>
                            </div>
                            <!-- /counter -->

                            <div class="col-md-4">
                                <div class="counter-icon-number">
                                    <div class="counter-icon">
                                        <i class="text-gradiant flaticon-book"></i>
                                    </div>
                                    <div class="counter-number">
                                        <span class="bold-font">{{$total_courses}}</span>
                                        <p>@lang('labels.frontend.home.online_available_courses')</p>
                                    </div>
                                </div>
                            </div>
                            <!-- /counter -->

                            <div class="col-md-3">
                                <div class="counter-icon-number">
                                    <div class="counter-icon">
                                        <i class="text-gradiant flaticon-group"></i>
                                    </div>
                                    <div class="counter-number">
                                        <span class="bold-font">{{$total_teachers}}</span>
                                        <p>@lang('labels.frontend.home.teachers')</p>
                                    </div>
                                </div>
                            </div>
                            <!-- /counter -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End of Search Courses
            ============================================= -->
    @endif

    @if($sections->popular_courses->status == 1)
        @include('frontend-rtl.layouts.partials.popular_courses',['class'=>'popular-three'])
    @endif


    @if($sections->reasons->status == 1)
        <!-- Start why choose section
        ============================================= -->
        @include('frontend-rtl.layouts.partials.why_choose_us',['class'=>'pb-5'])
        <!-- End why choose section
        ============================================= -->
    @endif



    @if($sections->featured_courses->status == 1)
        <!-- Start of best course
        ============================================= -->
        <div id="best-product">
            @include('frontend-rtl.layouts.partials.browse_courses')
        </div>
        <!-- End of best course
            ============================================= -->
    @endif


    @if($sections->teachers->status == 1)

        <!-- Start of genius teacher v2
    ============================================= -->
        <section id="genius-teacher-2" class="genius-teacher-section-2 one-page-teacher backgroud-style">
            <div class="container">
                <div class="section-title mb20  headline text-center">
                    <span class="subtitle text-uppercase">@lang('labels.frontend.home.learn_new_skills')</span>
                    <h2>@lang('labels.frontend.home.popular_teachers').</h2>
                </div>
                @if(count($teachers)> 0)
                    <div class="teacher-third-slide">
                        @foreach($teachers as $key=>$item)
                            {{--@if($key%2 == 0 && (count($teachers) > 5))--}}
                                {{--<div class="teacher-double">--}}
                                    {{--@endif--}}
                                    <div class="teacher-img-content relative-position">
                                        <img height="210px" width="210px" src="{{$item->picture}}" alt="">
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
                                        </div>
                                        {{--<div class="teacher-category float-right">--}}
                                        {{--<span class="st-name">Mobile Apps </span>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--@if($key%2 == 1)--}}
                                {{--</div>--}}
{{--                            @endif--}}
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
        <!-- End of genius teacher v2
            ============================================= -->
    @endif




    @if($sections->latest_news->status == 1)
        <!-- Start latest section
        ============================================= -->
        @include('frontend.layouts.partials.latest_news')
        <!-- End latest section
            ============================================= -->
    @endif



    @if($sections->search_section->status == 1)
        <!-- Start of Search Courses
        ============================================= -->
    <section id="search-course-2" class="search-course-section home-third-course-search backgroud-style">
        <div class="container">
            <div class="section-title mb20 headline text-center">
                <span class="subtitle text-uppercase">@lang('labels.frontend.home.learn_new_skills')</span>
                <h2>@lang('labels.frontend.home.search_courses')</h2>
            </div>
            <div id="search-course" class="search-course mb30 relative-position">
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
        </div>
    </section>
    <!-- End of Search Courses
        ============================================= -->
    @endif



    @if($sections->faq->status == 1)
        <!-- Start FAQ section
        ============================================= -->
        @include('frontend-rtl.layouts.partials.faq-with-bg')
        <!-- End FAQ section
            ============================================= -->
    @endif


    @if($sections->testimonial->status == 1)
        <!-- Start of testimonial secound section
        ============================================= -->
        @include('frontend-rtl.layouts.partials.testimonial')
        <!-- End  of testimonial secound section
            ============================================= -->
    @endif


    @if($sections->sponsors->status == 1)
        @if(count($sponsors) > 0 )
            <!-- Start of sponsor section
        ============================================= -->
            @include('frontend-rtl.layouts.partials.sponsors')
            <!-- End of sponsor section
       ============================================= -->
        @endif
    @endif



    @if($sections->contact_form->status == 1)
        <!-- Start of contact area form
        ============================================= -->
    <section id="contact-form" class="contact-form-area_3">
        <div class="container">
            <div class="section-title mb45 headline text-center">
                <h2>@lang('labels.frontend.contact.send_us_a_message')</h2>
            </div>

            <div class="contact_third_form">
                <form class="contact_form" action="{{route('contact.send')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="contact-info">
                                <input class="name" name="name" type="text" placeholder="@lang('labels.frontend.contact.your_name')">
                                @if($errors->has('name'))
                                    <span class="help-block text-danger">{{$errors->first('name')}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="contact-info">
                                <input class="email" name="email" type="email" placeholder="@lang('labels.frontend.contact.your_email')">
                                @if($errors->has('email'))
                                    <span class="help-block text-danger">{{$errors->first('email')}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="contact-info">
                                <input class="number" name="phone" type="number" placeholder="@lang('labels.frontend.contact.phone_number')">
                                @if($errors->has('phone'))
                                    <span class="help-block text-danger">{{$errors->first('phone')}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <textarea name="message" placeholder="@lang('labels.frontend.contact.message')"></textarea>
                    @if($errors->has('message'))
                        <span class="help-block text-danger">{{$errors->first('message')}}</span>
                    @endif
                    <div class="nws-button text-center  gradient-bg text-uppercase">
                        <button type="submit" value="Submit">@lang('labels.frontend.contact.send_email') <i class="fas fa-caret-right"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- End of contact area form
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
