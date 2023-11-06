
<!-- Start popular course
       ============================================= -->
@if(count($popular_courses) > 0)
    <section id="popular-course" class="popular-course-section {{isset($class) ? $class : ''}}">
        <div class="container">
            <div class="section-title mb20 headline text-left ">
                <span class="subtitle text-uppercase">@lang('labels.frontend.layouts.partials.learn_new_skills')</span>
                <h2>@lang('labels.frontend.layouts.partials.popular_courses')</h2>
            </div>
            <div id="course-slide-item" class="course-slide">
                @foreach($popular_courses as $item)
                    <div class="course-item-pic-text ">
                        <div class="course-pic relative-position mb25" @if($item->course_image != "")  style="background-image: url({{asset('storage/uploads/'.$item->course_image)}})" @endif>


                            <div class="course-price text-center gradient-bg">
                                @if($item->free == 1)
                                    <span> {{trans('labels.backend.courses.fields.free')}}</span>
                                @else
                                   <span>
                                        {!!  $item->strikePrice  !!}
                                       {{$appCurrency['symbol'].' '.$item->price}}
                                   </span>
                                @endif
                            </div>
                            <div class="course-details-btn">
                                <a class="text-uppercase" href="{{ route('courses.show', [$item->slug]) }}">@lang('labels.frontend.layouts.partials.course_detail') <i
                                            class="fas fa-arrow-right"></i></a>
                            </div>

                        </div>
                        <div class="course-item-text">
                            <div class="course-meta">
                                    <span class="course-category bold-font"><a
                                                href="{{route('courses.category',['category'=>$item->category->slug])}}">{{$item->category->name}}</a></span>
                                <span class="course-author bold-font">
                                @foreach($item->teachers as $teacher)
                                        <a href="#">{{$teacher->first_name}}</a></span>
                                @endforeach
                                <div class="course-rate ul-li">
                                    <ul>
                                        @for($i=1; $i<=(int)$item->rating; $i++)
                                            <li><i class="fas fa-star"></i></li>
                                        @endfor
                                    </ul>
                                </div>
                            </div>
                            <div class="course-title mt10 headline pb45 relative-position">
                                <h3><a href="{{ route('courses.show', [$item->slug]) }}">{{$item->title}}</a>
                                    @if($item->trending == 1)
                                        <span
                                                class="trend-badge text-uppercase bold-font"><i
                                                    class="fas fa-bolt"></i> @lang('labels.frontend.badges.trending')</span>
                                    @endif

                                </h3>
                            </div>
                            <div class="course-viewer ul-li">
                                <ul>
                                    <li><a href=""><i class="fas fa-user"></i> {{ $item->students()->count() }}
                                        </a>
                                    </li>
                                    <li><a href=""><i class="fas fa-comment-dots"></i> {{count($item->reviews) }}</a></li>
                                    {{--<li><a href="">125k Unrolled</a></li>--}}
                                </ul>
                            </div>
                            @include('frontend.layouts.partials.wishlist',['course' => $item->id, 'price' => $item->price])
                        </div>
                    </div>
                    <!-- /item -->
                @endforeach
            </div>
        </div>
    </section>
    <!-- End popular course
        ============================================= -->
@endif
