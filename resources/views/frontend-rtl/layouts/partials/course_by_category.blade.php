<section id="course-category" class="course-category-section">
    <div class="container">
        <div class="section-title mb45 headline text-center ">
            <span class="subtitle text-uppercase">@lang('labels.frontend.layouts.partials.courses_categories')</span>
            <h2>@lang('labels.frontend.layouts.partials.browse_course_by_category')</h2>
        </div>
        @if($course_categories)
            <div class="category-item">
                <div class="row">
                    @foreach($course_categories->take(8) as $category)
                        <div class="col-md-3">
                            <a href="{{route('courses.category',['category'=>$category->slug])}}">
                                <div class="category-icon-title text-center ">
                                    <div class="category-icon">
                                        <i class="text-gradiant {{$category->icon}}"></i>
                                    </div>
                                    <div class="category-title">
                                        <h4>{{$category->name}}</h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                @endforeach
                <!-- /category -->
                </div>
            </div>
        @endif
    </div>
</section>
