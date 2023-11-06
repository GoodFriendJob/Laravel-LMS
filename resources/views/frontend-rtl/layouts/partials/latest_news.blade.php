<section id="latest-area" class="latest-area-section {{isset($pt) ? $pt : ''}}">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="latest-area-content  ">
                    <div class="section-title-2 mb65 headline text-left">
                        <h2>@lang('labels.frontend.layouts.partials.latest_news_blog')</h2>
                    </div>
                    <div class="latest-news-posts">
                        @if(count($news) > 0)
                            @foreach($news as  $item)
                                <div class="latest-news-area">
                                    @if($item->image != null)
                                        <div class="latest-news-thumbnile relative-position"
                                             style="background-image: url('{{asset("storage/uploads/".$item->image)}}');">
                                            <div class="hover-search">
                                                {{--<i class="fas fa-search"></i>--}}
                                            </div>
                                            <div class="blakish-overlay"></div>
                                        </div>
                                    @endif

                                    <div class="date-meta">
                                        <i class="fas fa-calendar-alt"></i> {{$item->created_at->format('d M Y')}}
                                    </div>
                                    <h3 class="latest-title bold-font"><a
                                                href="{{route('blogs.index',['slug' => $item->slug.'-'.$item->id])}}">{{$item->title}}</a>
                                    </h3>
                                    <h3 class="latest-title text-primary"><a
                                                href="{{route('blogs.category',['category' => $item->category->slug])}}">{{$item->category->name}}</a>
                                    </h3>
                                    <div class="course-viewer ul-li">
                                        <ul>
                                            {{--<li><a href=""><i class="fas fa-user"></i> 1.220</a></li>--}}
                                            @if($item->comments->count() > 1)
                                                <li><a href=""><i
                                                                class="fas fa-comment-dots"></i>{{ $item->comments->count() }}
                                                    </a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>

                        @endforeach
                    @endif

                    <!-- /post -->

                        <div class="view-all-btn bold-font">
                            <a href="{{route('blogs.index')}}">@lang('labels.frontend.layouts.partials.view_all_news') <i class="fas fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-4">
                <div class="latest-area-content  ">
                    <div class="section-title-2 mb65 headline text-left">
                        <h2>@lang('labels.frontend.layouts.partials.trending_courses')</h2>
                    </div>
                    <div class="latest-news-posts">
                        @if(count($trending_courses) > 0)
                            @foreach($trending_courses as  $item)
                                <div class="latest-news-area">
                                    @if($item->image != null)
                                        <div class="latest-news-thumbnile relative-position"
                                             style="background-image: url('{{asset("storage/uploads/".$item->image)}}');">
                                            <div class="hover-search">
                                                {{--<i class="fas fa-search"></i>--}}
                                            </div>
                                            <div class="blakish-overlay"></div>
                                        </div>
                                    @endif
                                    <div class="date-meta">
                                        <i class="fas fa-calendar-alt"></i> {{$item->created_at->format('d M Y')}}
                                    </div>
                                    <h3 class="latest-title bold-font"><a
                                                href="{{route('courses.show',['slug'=>$item->slug])}}">{{$item->title}}</a>
                                    </h3>
                                    <h3 class="latest-title text-primary"><a
                                                href="{{route('courses.category',['category'=>$item->category->slug])}}">{{$item->category->name}}</a>
                                    </h3>
                                    <div class="course-viewer ul-li">
                                        <ul>
                                            <li><a href=""><i
                                                            class="fas fa-user"></i> {{$item->students->count()}}
                                                </a></li>

                                        </ul>
                                    </div>
                                </div>

                        @endforeach
                    @endif

                    <!-- /post -->

                        <div class="view-all-btn bold-font">
                            <a href="{{route('courses.all',['type'=>'trending'])}}">@lang('labels.frontend.layouts.partials.view_all_trending_courses')  <i
                                        class="fas fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="latest-area-content  ">
                    <div class="section-title-2 mb65 headline text-left">
                        <h2>@lang('labels.frontend.layouts.partials.popular_courses')</h2>
                    </div>
                    <div class="latest-news-posts">
                        @if(count($popular_courses) > 0)
                            @foreach($popular_courses->take(2) as  $item)
                                <div class="latest-news-area">
                                    @if($item->image != null)
                                        <div class="latest-news-thumbnile relative-position"
                                             style="background-image: url('{{asset("storage/uploads/".$item->image)}}');">
                                            <div class="hover-search">
                                                {{--<i class="fas fa-search"></i>--}}
                                            </div>
                                            <div class="blakish-overlay"></div>
                                        </div>
                                    @endif
                                    <div class="date-meta">
                                        <i class="fas fa-calendar-alt"></i> {{$item->created_at->format('d M Y')}}
                                    </div>
                                    <h3 class="latest-title bold-font"><a
                                                href="{{route('courses.show',['slug'=>$item->slug])}}">{{$item->title}}</a>
                                    </h3>
                                    <h3 class="latest-title text-primary"><a
                                                href="{{route('courses.category',['category'=>$item->category->slug])}}">{{$item->category->name}}</a>
                                    </h3>
                                    <div class="course-viewer ul-li">
                                        <ul>
                                            <li><a href=""><i
                                                            class="fas fa-user"></i> {{$item->students->count()}}
                                                </a></li>

                                        </ul>
                                    </div>
                                </div>
                        @endforeach
                    @endif

                    <!-- /post -->
                        <div class="view-all-btn bold-font">
                            <a href="{{route('courses.all',['type'=>'popular'])}}">@lang('labels.frontend.layouts.partials.view_all_popular_courses') <i
                                        class="fas fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>