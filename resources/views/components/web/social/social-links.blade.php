<div class="social__links">
    @forelse ($items as $item)
        <a class="social__link" href="{{ $getLink($item) }}" target="_blank" title="{{$item->name}}">
            <svg class="svg-sprite social__icon" width="48px" height="48px">
                <use xlink:href="{{ asset('images/web/svg/symbol/sprite.svg#'.$item->key) }}"></use>
            </svg>
        </a>
    @empty
    @endforelse
</div>
