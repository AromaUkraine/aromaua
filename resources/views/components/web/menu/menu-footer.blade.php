
@forelse ($items as $item)
    <div class="footer__col">
        @forelse ($item->children as $child)
            @if($child->page)
                <div class="footer__item">
                    <a class="footer__link {{ $getActiveClass($child) }}" href="{{ $getRoute($child->page->slug) }}">{{ $child->name }}</a>
                </div>
            @endif
        @empty
        @endforelse
    </div>
@empty
@endforelse
