<nav class="topline__menu topline-menu">
    @forelse($items as $item)
        <a class="topline-menu__link {{ $getActiveClass($item) }}" href="{{ $getRoute($item->page->slug ?? null) }}">{{ $item->name ?? null }}</a>
    @empty
   @endforelse
</nav>
