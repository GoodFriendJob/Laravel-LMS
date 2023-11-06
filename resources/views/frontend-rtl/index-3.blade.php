@extends('frontend-rtl.layouts.app'.config('theme_layout'))

@section('title', trans('labels.frontend.home.title').' | '.app_name())
@section('meta_description', '')
@section('meta_keywords','')

@section('css')
    <style>
        .my-alert{
            top: 40%;
            position: absolute;
            right: 0;
            z-index: 1000;
            left: 0;
            margin: auto;
            width: 40%;
        }
        @media only screen and  (max-width: 768px) {
            .my-alert{
                width: 100%;
            }
        }
    </style>
@endsection
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
        <section id="search-course" class="search-course-section search-course-secound">
            <div class="container">
                <div class="search-counter-up">
                    <div class="row">
                        <div class="col-md-4">
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

                        <div class="col-md-4">
                            <div class="counter-icon-number ">
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
                            <div class="counter-icon-number ">
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
        </section>
        <!-- End of Search Courses
            ============================================= -->
    @endif

    @if($sections->latest_news->status == 1)
        <!-- Start latest section
        ============================================= -->
        @include('frontend.layouts.partials.latest_news',['pt'=>'pt-5'])
        <!-- End latest section
            ============================================= -->
    @endif

    @if($sections->popular_courses->status == 1)
        @include('frontend.layouts.partials.popular_courses',['class'=>'popular-three' ])
    @endif



    @if($sections->reasons->status == 1)
        <!-- Start why choose section
        ============================================= -->
        @include('frontend.layouts.partials.why_choose_us')
        <!-- End why choose section
        ============================================= -->
    @endif



    @if($sections->featured_courses->status == 1)
        <!-- Start of best course
        ============================================= -->
        @include('frontend.layouts.partials.browse_courses', ['class'=>'bg-white pb-5' ])
        <!-- End of best course
            ============================================= -->
    @endif


    @if($sections->teachers->status == 1)
        <!-- Start of genius teacher v2
        ============================================= -->
        <section id="genius-teacher-2" class="genius-teacher-section-2 mb-5">
            <div class="container">
                <div class="section-title mb20  headline text-left">
                    <span class="subtitle ml42 text-uppercase">@lang('labels.frontend.home.learn_new_skills')</span>
                    <h2>@lang('labels.frontend.home.popular_teachers').</h2>
                </div>
                @if(count($teachers)> 0)
                    <div class="teacher-third-slide">
                        @foreach($teachers as $key=>$item)
                            @if($key%2 == 0 && (count($teachers) > 5))
                                <div class="teacher-double">
                                    @endif
                                    <div class="teacher-img-content relative-position">
                                        <img width="100%" src="{{$item->picture}}" alt="">
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
                                    </div>
                                    @if($key%2 == 1)
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
        <!-- End of genius teacher v2
            ============================================= -->
    @endif

    @if($sections->faq->status == 1)
        <!-- Start FAQ section
        ============================================= -->
        @include('frontend.layouts.partials.faq-with-bg')
        <!-- End FAQ section
            ============================================= -->
    @endif

    @if($sections->testimonial->status == 1)
        <!-- Start of testimonial secound section
        ============================================= -->
        @include('frontend.layouts.partials.testimonial')

        <!-- End  of testimonial secound section
            ============================================= -->
    @endif


    @if($sections->sponsors->status == 1)
        @if(count($sponsors) > 0 )
            <!-- Start of sponsor section
        ============================================= -->
            @include('frontend.layouts.partials.sponsors')
            <!-- End of sponsor section
       ============================================= -->
        @endif
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
