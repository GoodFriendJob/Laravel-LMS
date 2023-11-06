<div class="col-md-3">
    <div class="side-bar">
        <div class="side-bar-search">
            <form action="{{route('blogs.search')}}" method="get">
                <input type="text" class="" name="q" placeholder="@lang('labels.frontend.blog.search_blog')">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
        @if($categories != "")
        <div class="side-bar-widget">
            <h2 class="widget-title text-capitalize">@lang('labels.frontend.blog.blog_categories')</h2>
            <div class="post-categori ul-li-block">
                <ul>
                    @if(count($categories) > 0)

                        @foreach($categories as $item)
                            <li class="cat-item @if(isset($category) && ($item->slug == $category->slug))  active @endif "><a href="{{route('blogs.category',[
                                                'category' => $item->slug])}}">{{$item->name}}</a></li>

                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
        @endif



        @if(count($popular_tags) > 0)
            <div class="side-bar-widget">
                <h2 class="widget-title text-capitalize">@lang('labels.frontend.blog.popular_tags')</h2>
                <div class="tag-clouds ul-li">
                    <ul>
                        @foreach($popular_tags as $item)

                            <li @if(isset($tag) && ($item->slug == $tag->slug))  class="active" @endif ><a href="{{route('blogs.tag',['tag'=>$item->slug])}}">{{$item->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif


        @if($global_featured_course != "")
            <div class="side-bar-widget">
                <h2 class="widget-title text-capitalize">@lang('labels.frontend.blog.featured_course')</h2>
                <div class="featured-course">
                    <div class="best-course-pic-text relative-position pt-0">
                        <div class="best-course-pic relative-position " @if($global_featured_course->course_image != "") style="background-image: url({{asset('storage/uploads/'.$global_featured_course->course_image)}})" @endif>

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
