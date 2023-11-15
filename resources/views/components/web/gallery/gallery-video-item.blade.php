<a class="youtube-link youtube-link--float-right js-popup-youtube" href="{{ $link }}">
    <figure class="youtube-link__wrap-img ie">
        <picture>
            <source srcset="{{ $getWebp($image) }}" type="image/webp">
            <img class="youtube-link__img" src="{{ $image }}" alt="{{$alt}}">
        </picture>
    </figure>
    <svg class="svg-sprite youtube-link__icon" width="194px" height="194px">
        <use xlink:href="{{ asset('images/web/svg/symbol/sprite.svg#play') }}"></use>
    </svg>
</a>


