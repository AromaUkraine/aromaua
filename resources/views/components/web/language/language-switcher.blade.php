<ul class="topline__language lang-switcher">
    @foreach($languages as $lang)
        @if($pageActiveAndPublish($lang->short_code))
            <li class="lang-switcher__item">
                <a class="lang-switcher{{ $getActive($lang)}}" href="{!! $getUrl($lang->short_code) !!} "> {{ $lang->short_name ?? $lang->short_code }} </a>
            </li>
        @endif
    @endforeach
</ul>
