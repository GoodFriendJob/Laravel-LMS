<section id="slide" class="slider-section @if(config('theme_layout') == 3) pt150 @endif">
    <div id="slider-item" class="slider-item-details">
        @foreach($slides as $slide)
            <div class="slider-area slider-bg-5 relative-position" style="background: none;">

                <div class="bg-image @if($slide->overlay == 1) overlay  @endif"
                     style="background-image: url({{asset('storage/uploads/'.$slide->bg_image)}})"></div>
                @php $content = json_decode($slide->content) @endphp
                <div class="slider-text">
                    @if(isset($content->widget))
                        @if($content->widget->type == 2)
                            <div class="layer-1-3">

                                <span class="timer-data d-none" data-timer="{{$content->widget->timer}}"></span>
                                <div class="coming-countdown ul-li">
                                    <ul>
                                        <li class="days">
                                            <span class="number"></span>
                                            <span class>@lang('labels.frontend.layouts.partials.days')</span>
                                        </li>

                                        <li class="hours">
                                            <span class="number"></span>
                                            <span class>@lang('labels.frontend.layouts.partials.hours')</span>
                                        </li>

                                        <li class="minutes">
                                            <span class="number"></span>
                                            <span class>@lang('labels.frontend.layouts.partials.minutes')</span>
                                        </li>

                                        <li class="seconds">
                                            <span class="number"></span>
                                            <span class>@lang('labels.frontend.layouts.partials.seconds')</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endif
                    @endif

                    <div class="section-title mb20 headline text-center ">
                        @if($content->sub_text)
                            <div class="layer-1-1">
                                <span class="subtitle text-uppercase">{{$content->sub_text}}</span>
                            </div>
                        @endif
                        @if($content->hero_text)
                            <div class="layer-1-3">
                                <h2><span>{{ $content->hero_text }}</span></h2>
                            </div>
                        @endif
                    </div>
                    @if(isset($content->widget))
                        <div class="layer-1-3">
                            @if($content->widget->type == 1)
                                <div class="search-course mb30 relative-position">
                                    <form action="{{route('search')}}" method="get">
                                        <input class="course" name="q" type="text"
                                               placeholder="@lang('labels.frontend.layouts.partials.search_placeholder')">
                                        <div class="nws-button text-center  gradient-bg text-capitalize">
                                            <button type="submit" value="Submit">@lang('labels.frontend.layouts.partials.search_courses')</button>
                                        </div>
                                    </form>
                                </div>
                            @endif


                        </div>
                    @endif
                    @if(isset($content->buttons))
                        <div class="layer-1-4">
                            <div class="about-btn text-center">
                                @foreach($content->buttons as $button)
                                    <div class="genius-btn text-center text-uppercase ul-li-block bold-font">
                                        <a href="{{$button->link}}">{{$button->label}} <i
                                                    class="fas fa-caret-right"></i></a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif


                </div>
            </div>
        @endforeach
    </div>
</section>
<!-- End of slider section
============================================= -->

@push('after-scripts')
    <script>
        if ($('.coming-countdown').length > 0) {
            var date = $('.coming-countdown').siblings('.timer-data').data('timer')
            // Specify the deadline date
            var deadlineDate = new Date(date).getTime();
            // var deadlineDate = new Date('2019/02/09 22:00').getTime();

            // Cache all countdown boxes into consts
            var countdownDays = document.querySelector('.days .number');
            var countdownHours = document.querySelector('.hours .number');
            var countdownMinutes = document.querySelector('.minutes .number');
            var countdownSeconds = document.querySelector('.seconds .number');

            // Update the count down every 1 second (1000 milliseconds)
            setInterval(function () {
                // Get current date and time
                var currentDate = new Date().getTime();

                // Calculate the distance between current date and time and the deadline date and time
                var distance = deadlineDate - currentDate;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Insert the result data into individual countdown boxes
                countdownDays.innerHTML = days;
                countdownHours.innerHTML = hours;
                countdownMinutes.innerHTML = minutes;
                countdownSeconds.innerHTML = seconds;

                if (distance < 0) {
                    $('.coming-countdown').empty();
                }
            }, 1000);

        }

    </script>
@endpush