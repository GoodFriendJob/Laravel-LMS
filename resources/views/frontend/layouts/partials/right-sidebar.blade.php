<div class="col-md-3">
    <div class="side-bar">


        @if($recent_news->count() > 0)
            <div class="side-bar-widget first-widget">
                <h2 class="widget-title text-capitalize">@lang('labels.frontend.layouts.partials.recent_news')</h2>
                <div class="latest-news-posts">
                    @foreach($recent_news as $item)
                        <div class="latest-news-area">

                            @if($item->image != "")
                                <div class="latest-news-thumbnile relative-position"
                                     style="background-image: url({{asset('storage/uploads/'.$item->image)}})">
                                    <div class="blakish-overlay"></div>
                                </div>
                            @endif
                            <div class="date-meta">
                                <i class="fas fa-calendar-alt"></i> {{$item->created_at->format('d M Y')}}
                            </div>
                            <h3 class="latest-title bold-font"><a href="{{route('blogs.index',['slug'=>$item->slug.'-'.$item->id])}}">{{$item->title}}</a></h3>
                        </div>
                        <!-- /post -->
                    @endforeach


                    <div class="view-all-btn bold-font">
                        <a href="{{route('blogs.index')}}">@lang('labels.frontend.layouts.partials.view_all_news') <i class="fas fa-chevron-circle-right"></i></a>
                    </div>
                </div>
            </div>

        @endif


        @if($global_featured_course != "")
            <div class="side-bar-widget">
                <h2 class="widget-title text-capitalize">@lang('labels.frontend.layouts.partials.featured_course')</h2>
                <div class="featured-course">
                    <div class="best-course-pic-text relative-position pt-0">
                        <div class="best-course-pic relative-position " style="background-image: url({{asset('storage/uploads/'.$global_featured_course->course_image)}})">

                            @if($global_featured_course->trending == 1)
                                <div class="trend-badge-2 text-center text-uppercase">
                                    <i class="fas fa-bolt"></i>
                                    <span>@lang('labels.frontend.badges.trending')</span>
                                </div>
                            @endif
                        </div>
                        <div class="best-course-text" style="left: 0;right: 0;">
                            <div class="course-title mb20 headline relative-position">
                                <h3><a href="{{ route('courses.show', [$global_featured_course->slug]) }}">{{$global_featured_course->title}}</a></h3>
                            </div>
                            <div class="course-meta">
                                <span class="course-category"><a href="{{route('courses.category',['category'=>$global_featured_course->category->slug])}}">{{$global_featured_course->category->name}}</a></span>
                                <span class="course-author">{{ $global_featured_course->students()->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>