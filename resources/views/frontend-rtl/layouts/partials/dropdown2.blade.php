
@if($item->subs)

<li class="card ">
    <div class="card-header" id="heading{{$item->id}}">
        <button class="menu-link" data-toggle="collapse" data-target="#collapse{{$item->id}}"
                aria-expanded="false" aria-controls="collapse{{$item->id}}">
            {{$item->label}}
        </button>
    </div>
    <ul id="collapse{{$item->id}}" class="submenu collapse " aria-labelledby="heading{{$item->id}}"
        data-parent="#accordion" style="">
        @foreach($item->subs as $item)
            @include('frontend.layouts.partials.dropdown2', $item)
        @endforeach
    </ul>
</li>
@else
    <li class="card">
        <a class="menu-link" id="menu-{{$item->id}}" href="{{$item->link}}">{{$item->label}}</a>
    </li>
@endif