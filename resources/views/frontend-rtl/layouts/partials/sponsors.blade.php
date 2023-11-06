<section id="sponsor" class="sponsor-section">
    <div class="container">
        <div class="section-title-2 mb65 headline text-left ">
            <h2>{{env('APP_NAME')}} <span>@lang('labels.frontend.layouts.partials.sponsors')</span></h2>
        </div>
        <div class="sponsor-item sponsor-1 text-center">
            @foreach($sponsors as $sponsor)
                <div class="sponsor-pic text-center">
                    <a href="{{ ($sponsor->link != "") ? $sponsor->link : '#' }}">
                        <img src={{asset("storage/uploads/".$sponsor->logo)}} alt="{{$sponsor->name}}">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
