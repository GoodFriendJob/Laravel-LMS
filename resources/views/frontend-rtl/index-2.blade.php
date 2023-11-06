@extends('frontend-rtl.layouts.app'.config('theme_layout'))
@php $no_footer = true; @endphp

@section('title', trans('labels.frontend.home.title').' | '.app_name())
@section('meta_description', '')
@section('meta_keywords','')

@push("after-styles")
    <style>
        #search-course {
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
    </style>
@endpush
@php
    $footer_data = json_decode(config('footer_data'));
@endphp
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


    @if($sections->sponsors->status == 1)
        @if(count($sponsors) > 0 )
    <!-- Start of sponsor section
        ============================================= -->
    <div id="sponsor" class="sponsor-section sponsor-2">
        <div class="container">
            <div class="sponsor-item">
                @foreach($sponsors as $sponsor)
                    <div class="sponsor-pic text-center">
                        <a href="{{ ($sponsor->link != "") ? $sponsor->link : '#' }}">
                            <img src={{asset("storage/uploads/".$sponsor->logo)}} alt="{{$sponsor->name}}">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
   @endif
    <!-- End of sponsor section
        ============================================= -->


    <!-- Start popular course
        ============================================= -->
    @if($sections->popular_courses->status == 1)
        @include('frontend.layouts.partials.popular_courses')
    @endif
    <!-- End popular course
    ============================================= -->

    @if($sections->search_section->status == 1)
        <!-- Start of Search Courses
    ============================================= -->
        <section id="search-course" class="search-course-section home-secound-course-search backgroud-style">
            <div class="container">
                <div class="section-title mb20 headline text-center">
                    <span class="subtitle text-uppercase">@lang('labels.frontend.home.learn_new_skills')</span>
                    <h2>@lang('labels.frontend.home.search_courses')</h2>
                </div>
                <div class="search-course mb30 relative-position">
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
                                <button type="submit" value="Submit">@lang('labels.frontend.home.search_course')</button>
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

    @if($sections->latest_news->status == 1)
        <!-- Start latest section
        ============================================= -->
        @include('frontend.layouts.partials.latest_news')
        <!-- End latest section
            ============================================= -->
    @endif


    @if($sections->featured_courses->status == 1)
        <!-- Start of best course
        ============================================= -->
        @include('frontend.layouts.partials.browse_courses')
        <!-- End of best course
            ============================================= -->
    @endif



    @if($sections->faq->status == 1)
        <!-- Start FAQ section
        ============================================= -->
        @include('frontend.layouts.partials.faq',['classes' => 'faq-secound-home-version backgroud-style'])
        <!-- End FAQ section
            ============================================= -->
    @endif


    @if($sections->course_by_category->status == 1)
        <!-- Start Course category
        ============================================= -->
        <section id="course-category" class="course-category-section home-secound-version">
            <div class="container">
                <div class="section-title mb20 headline text-left">
                    <span class="subtitle ml42 text-uppercase">@lang('labels.frontend.layouts.partials.courses_categories')</span>
                    <h2>@lang('labels.frontend.layouts.partials.browse_course_by_category')</h2>
                </div>
                <div class="category-item category-slide-item">
                    @if($course_categories)
                        @foreach($course_categories as $key=>$category)
                            @if($key%2 == 0)
                                <div class="category-slide-content">
                                    @endif
                                    <a href="{{route('courses.category',['category'=>$category->slug])}}">
                                        <div class="category-icon-title text-center">
                                            <div class="category-icon">
                                                <i class="text-gradiant {{$category->icon}}"></i>
                                            </div>
                                            <div class="category-title">
                                                <h4>{{$category->name}}</h4>
                                            </div>
                                        </div>
                                    </a>
                                    @if($key%2 == 1)
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </section>
        <!-- End Course category
            ============================================= -->
    @endif

    @if($sections->testimonial->status == 1)
        <!-- Start secound testimonial section
        ============================================= -->
    <section id="testimonial-secound" class="secound-testimoinial-section">
        <div class="container">
            <div class="testimonial-slide">
                <div class="section-title mb35 headline text-center">
                    <span class="subtitle text-uppercase">@lang('labels.frontend.home.what_they_say_about_us')</span>
                    <h2>@lang('labels.frontend.layouts.partials.students_testimonial')</h2>
                </div>
                @if($testimonials->count() > 0)
                <div class="testimonial-secound-slide-area">
                    @foreach($testimonials as $item)

                    <div class="student-qoute text-center">
                        <p>{{$item->content}}</p>
                        <div class="student-name-designation">
                            <span class="st-name bold-font">{{$item->name}}  </span>
                            <span class="st-designation">{{$item->occupation}}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </section>
    <!-- End secound testimonial section
        ============================================= -->
    @endif


    @if($sections->teachers->status == 1)
        <!-- Start secound teacher section
        ============================================= -->
    <section id="teacher-2" class="secound-teacher-section">
        <div class="container">
            <div class="section-title mb35 headline text-left">
                <span class="subtitle ml42  text-uppercase">@lang('labels.frontend.home.our_professionals')</span>
                <h2>{{env('APP_NAME')}} <span>@lang('labels.frontend.home.teachers').</span></h2>
            </div>
            <div class="teacher-secound-slide">
                @if(count($teachers)> 0)
                    @foreach($teachers as $item)
                        <div class="teacher-img-text relative-position text-center">
                            <div class="teacher-img-social relative-position" >
                                <img height="200px" width="200px" src="{{$item->picture}}" alt="{{$item->full_name}}">
                                <div class="blakish-overlay"></div>
                                <div class="teacher-social-list ul-li">
                                    <ul>
                                        <li><a href="{{'mailto:'.$item->email}}"><i class="fa fa-envelope"></i></a></li>
                                        <li><a href="{{route('admin.messages',['teacher_id'=>$item->id])}}"><i class="fa fa-comments"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="teacher-name-designation mt15">
                                <span class="teacher-name">{{$item->full_name}}</span>
                                {{--<span class="teacher-designation">Mobile Apps</span>--}}
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>

            <div class="genius-btn gradient-bg text-center text-uppercase ul-li-block bold-font">
                <a href="{{route('teachers.index')}}">@lang('labels.frontend.home.all_teachers') <i class="fas fa-caret-left"></i></a>
            </div>
        </div>
    </section>
    <!-- End teacher section
        ============================================= -->
    @endif

    @if($sections->contact_us->status == 1)
        <!-- Start Of scound contact section
        ============================================= -->
    <section id="contact_secound" class="contact_secound_section backgroud-style">
        <div class="container">
            <div class="contact_secound_content">
                <div class="row">
                    <div class="col-md-6">
                        @if(config('contact_data') != "")
                            @php
                                $contact_data = contact_data(config('contact_data'));
                            @endphp
                        <div class="contact-left-content">
                            <div class="section-title  mb45 headline text-left">
                                <span class="subtitle ml42  text-uppercase">@lang('labels.frontend.layouts.partials.contact_us')</span>
                                <h2><span>@lang('labels.frontend.layouts.partials.get_in_touch')</span></h2>
                                <p>
                                    {{ $contact_data["short_text"]["value"] }}
                                </p>
                            </div>

                            <div class="contact-address">
                                <div class="contact-address-details">
                                    <div class="address-icon relative-position text-center float-left">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="address-details ul-li-block">
                                        <ul>
                                            @if($contact_data["primary_address"]["status"] == 1)
                                                <li>
                                                    <span>@lang('labels.frontend.layouts.partials.primary'): </span>{{$contact_data["primary_address"]["value"]}}
                                                </li>
                                            @endif

                                            @if($contact_data["secondary_address"]["status"] == 1)
                                                <li>
                                                    <span>@lang('labels.frontend.layouts.partials.second'): </span>{{$contact_data["secondary_address"]["value"]}}
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>

                                <div class="contact-address-details">
                                    <div class="address-icon relative-position text-center float-left">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="address-details ul-li-block">
                                        <ul>
                                            @if($contact_data["primary_phone"]["status"] == 1)
                                                <li>
                                                    <span>@lang('labels.frontend.layouts.partials.primary'): </span>{{$contact_data["primary_phone"]["value"]}}
                                                </li>
                                            @endif

                                            @if($contact_data["secondary_phone"]["status"] == 1)
                                                <li>
                                                    <span>@lang('labels.frontend.layouts.partials.second'): </span>{{$contact_data["secondary_phone"]["value"]}}
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>

                                <div class="contact-address-details">
                                    <div class="address-icon relative-position text-center float-left">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="address-details ul-li-block">
                                        <ul>
                                            @if($contact_data["primary_email"]["status"] == 1)
                                                <li>
                                                    <span>@lang('labels.frontend.layouts.partials.primary'): </span>{{$contact_data["primary_email"]["value"]}}
                                                </li>
                                            @endif

                                            @if($contact_data["secondary_email"]["status"] == 1)
                                                <li>
                                                    <span>@lang('labels.frontend.layouts.partials.second'): </span>{{$contact_data["secondary_email"]["value"]}}
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                       @endif
                    </div>

                    <div class="col-md-6">
                        <div class="contact_secound_form text-white">
                            <div class="section-title-2 mb65 headline text-left">
                                <h2>@lang('labels.frontend.contact.send_us_a_message')</h2>
                            </div>
                            <form class="contact_form" action="{{route('contact.send')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="contact-info">
                                    <input class="name @if($errors->has('name')) border-bottom border-danger @endif" name="name" type="text" placeholder="@lang('labels.frontend.contact.your_name')">
                                </div>
                                <div class="contact-info">
                                    <input class="email  @if($errors->has('email')) border-bottom border-danger @endif" name="email" type="email" placeholder="@lang('labels.frontend.contact.your_email')">
                                </div>
                                <textarea name="message" class="@if($errors->has('message')) border-bottom border-danger @endif" placeholder="@lang('labels.frontend.contact.message')"></textarea>

                                <div class="nws-button text-center  gradient-bg text-capitalize">
                                    <button type="submit" value="Submit">@lang('labels.frontend.contact.send_message_now') <i
                                                class="fas fa-caret-right"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer_2 backgroud-style">
            <div class="container">
                <div class="back-top text-center mb45">
                    <a class="scrollup" href="#"><img src={{asset("assets/img/banner/bt.png")}} alt=""></a>
                </div>
                <div class="footer_2_logo text-center">
                    <img src={{asset("storage/logos/".config('logo_w_image'))}} alt="">
                </div>

                <div class="footer_2_subs text-center">
                    @if($footer_data->short_description->status == 1)
                    <p>{!! $footer_data->short_description->text !!} </p>
                    @endif

                    @if($footer_data->newsletter_form->status == 1)
                    <div class="subs-form relative-position">
                        <form action="{{route("subscribe")}}" method="post">
                            @csrf
                            <input class="email" name="subs_email" required type="email" placeholder="@lang('labels.frontend.layouts.partials.email_address').">
                            <div class="nws-button text-center  gradient-bg text-uppercase">
                                <button type="submit" value="Submit">@lang('labels.frontend.layouts.partials.subscribe_now')</button>
                            </div>
                            @if($errors->has('subs_email'))
                                <p class="text-danger text-left">{{$errors->first('subs_email')}}</p>
                            @endif
                        </form>
                    </div>
                    @endif
                </div>
                @if($footer_data->bottom_footer->status == 1)
                <div class="copy-right-menu">
                    <div class="row">
                        @if($footer_data->copyright_text->status == 1)
                        <div class="col-md-5">
                            <div class="copy-right-text">
                                <p>{!!  $footer_data->copyright_text->text !!}</p>
                            </div>
                        </div>
                        @endif

                            @if(($footer_data->social_links->status == 1) && (count($footer_data->social_links->links) > 0))
                        <div class="col-md-3">
                            <div class="footer-social  text-center ul-li">
                                <ul>
                                    @foreach($footer_data->social_links->links as $item)
                                        <li><a href="{{$item->link}}"><i class="{{$item->icon}}"></i></a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                         @endif

                            @if(($footer_data->bottom_footer_links->status == 1) && (count($footer_data->bottom_footer_links->links) > 0))
                        <div class="col-md-4">
                            <div class="copy-right-menu-item float-right ul-li">
                                <ul>
                                    @foreach($footer_data->bottom_footer_links->links as $item)
                                        <li><a href="{{$item->link}}">{{$item->label}}</a></li>
                                    @endforeach
                                        <li><a href="{{route('frontend.certificates.getVerificationForm')}}">@lang('labels.frontend.layouts.partials.certificate_verification')</a></li>
                                </ul>
                            </div>
                        </div>
                         @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
    <!-- ENd Of scound contact section
        ============================================= -->
    @endif

@endsection

@push('after-scripts')
    <script>
        $('ul.product-tab').find('li:first').addClass('active');
    </script>
@endpush