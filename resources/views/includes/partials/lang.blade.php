<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownLanguageLink">
    {{--
        @foreach(array_keys(config('locale.languages')) as $lang)
    @if($lang != app()->getLocale())
        <small><a href="{{ route('languageselect',$lang)}}" class="dropdown-item">{{(trans('menus.language-picker.langs.'.$lang)) ? trans('menus.language-picker.langs.'.$lang) : $lang  }}</a></small>
    @endif
    @endforeach
    --}}
    @foreach($locales as $lang)
        @if($lang != app()->getLocale())
            <small><a href="{{ route('languageselect',$lang)}}" class="dropdown-item">{{(trans('menus.language-picker.langs.'.$lang)) ? trans('menus.language-picker.langs.'.$lang) : $lang  }}</a></small>
        @endif
    @endforeach
</div>
