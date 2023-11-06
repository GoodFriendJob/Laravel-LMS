@if($item->subs)
    <li>
        <a class="" id="menu-{{$item->id}}" href="{{$item->link}}">{{trans('custom-menu.'.$menu_name.'.'.str_slug($item->label))}}</a>
        <ul class="depth-{{$item->depth}}">
            @foreach($item->subs as $item)
                @include('frontend.layouts.partials.dropdown', $item)
            @endforeach
        </ul>
    </li>
@else
    <li>
        <a class="" id="menu-{{$item->id}}" href="{{$item->link}}">{{trans('custom-menu.'.$menu_name.'.'.str_slug($item->label))}}</a>
    </li>
@endif
