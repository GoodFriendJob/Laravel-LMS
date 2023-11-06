<section id="testimonial_2" class="testimonial_2_section">
    <div class="container">
        <div class="testimonial-slide">
            <div class="section-title-2 mb65 headline text-left">
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
            @endif
        </div>
    </div>
</section>
