@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}

        @if ($paginator->onFirstPage())
            <li class="pagination__item pagination__item--disable">
                <a class="pagination__link" href="#">
                    <svg class="svg-sprite pagination__icon" width="10px" height="18px">
                        <use xlink:href="{{ asset('images/web/svg/symbol/sprite.svg#arrow-prev') }}"></use>
                    </svg>
                </a>
            </li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">
                    <svg class="svg-sprite pagination__icon" width="10px" height="18px">
                        <use xlink:href="{{ asset('images/web/svg/symbol/sprite.svg#arrow-prev') }}"></use>
                    </svg>
                </a>
            </li>
        @endif
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="pagination__item pagination__item--current">
                            <a class="pagination__link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @else
                        <li class="pagination__item">
                            <a class="pagination__link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif

                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">
                    <svg class="svg-sprite pagination__icon" width="10px" height="18px">
                        <use xlink:href="{{ asset('images/web/svg/symbol/sprite.svg#arrow-next') }}"></use>
                    </svg>
                </a>
            </li>
        @else
            <li class="pagination__item pagination__item--disable">
                <a class="pagination__link" href="{{ $paginator->nextPageUrl() }}">
                    <svg class="svg-sprite pagination__icon" width="10px" height="18px">
                        <use xlink:href="{{ asset('images/web/svg/symbol/sprite.svg#arrow-next') }}"></use>
                    </svg>
                </a>
            </li>
        @endif
    </ul>
@endif
