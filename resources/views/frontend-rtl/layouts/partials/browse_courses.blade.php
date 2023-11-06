<section id="best-course" class="best-course-section {{isset($class) ? $class : ''}}">
    <div class="container">
        <div class="section-title mb45 headline text-center ">
            <span class="subtitle text-uppercase">@lang('labels.frontend.layouts.partials.search_our_courses')</span>
            <h2>@lang('labels.frontend.layouts.partials.browse_featured_course')</h2>
        </div>
        <div class="best-course-area mb45">
            <div class="row">
                @if(count($featured_courses) > 0)
                    @foreach($featured_courses as $item)
                        <div class="col-md-3">
                            <div class="best-course-pic-text relative-position ">
                                <div class="best-course-pic relative-position" @if($item->course_image != "")  style="background-image: url({{asset('storage/uploads/'.$item->course_image)}})" @endif>

                                    @if($item->trending == 1)
                                        <div class="trend-badge-2 text-center text-uppercase">
                                            <i class="fas fa-bolt"></i>
                                            <span>@lang('labels.frontend.badges.trending')</span>
                                        </div>
                                    @endif
                                        @if($item->free == 1)
                                            <div class="trend-badge-3 text-center text-uppercase">
                                                <i class="fas fa-bolt"></i>
                                                <span>@lang('labels.backend.courses.fields.free')</span>
                                            </div>
                                        @endif
                                    <div class="course-price text-center gradient-bg">
                                        @if($item->free == 1)
                                            <span> {{trans('labels.backend.courses.fields.free')}}</span>
                                        @else
                                            <span>
                                                {!! $item->strikePrice !!}
                                                {{$appCurrency['symbol'].' '.$item->price}}</span>
                                        @endif
                                    </div>
                                    <div class="course-rate ul-li">
                                        <ul>
                                            @for($i=1; $i<=(int)$item->rating; $i++)
                                                <li><i class="fas fa-star"></i></li>
                                            @endfor
                                        </ul>
                                    </div>
                                    <div class="course-details-btn">
                                        <a class="text-uppercase" href="{{ route('courses.show', [$item->slug]) }}">@lang('labels.frontend.layouts.partials.course_detail') <i class="fas fa-arrow-right"></i></a>
                                    </div>
                                    <div class="blakish-overlay"></div>
                                </div>
                                <div class="best-course-text">
                                    <div class="course-title mb20 headline relative-position">
                                        <h3>
                                            <a href="{{ route('courses.show', [$item->slug]) }}">{{$item->title}}</a>
                                        </h3>
                                    </div>
                                    <div class="course-meta">
                                            <span class="course-category"><a
                                                        href="{{route('courses.category',['category'=>$item->category->slug])}}">{{$item->category->name}}</a></span>
                                        <span class="course-author">
                                                <a href="#">
                                                    {{ $item->students()->count() }}
                                                    @lang('labels.frontend.layouts.partials.students')</a>
                                            </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h4 class="text-center">@lang('labels.general.no_data_available')</h4>
                @endif

            </div>
        </div>
    </div>
</section>
