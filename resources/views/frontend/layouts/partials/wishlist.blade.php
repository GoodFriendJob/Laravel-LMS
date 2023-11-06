@if(auth()->check() && (auth()->user()->hasRole('student')))
<div class="text-center mt-3">
    <form name="wishlist-form" action="{{ route('add-to-wishlist') }}" method="POST">
    @csrf
        <input type="hidden" name="course_id" value="{{ $course }}">
        <input type="hidden" name="price" value="{{ $price }}">
    <button type="submit" class="btn gradient-bg text-white font-weight-bold wishlist-btn">
        <i class="far fa-heart"></i>
        @lang('strings.frontend.general.add_to_wishlist')
    </button>
    </form>
</div>
@endif
@if(!auth()->check())
<div class="text-center mt-3">
    <a id="openLoginModal" data-target="#myModal" href="#" class="btn gradient-bg text-white font-weight-bold">
        <i class="far fa-heart"></i>
        @lang('strings.frontend.general.add_to_wishlist')
    </a>
</div>
@endif

