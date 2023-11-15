<div class="card">
    <a class="card__link" href="{{ route('page', $category->slug) }}" title="{{ $getTitle }}">

        @forelse($category->gallery as $item)
            @if($loop->first)
                <figure class="card__wrap-img">
                    <picture>
                        <source srcset="{{ $getWebp($item) }}" type="image/webp">
                        <img src="{{ $item->image }}" alt="{{ $category->name }}">
                    </picture>
                </figure>
            @endif
        @empty
        @endforelse
        <div class="card__title">{{ $category->name }}</div>
    </a>
</div>
