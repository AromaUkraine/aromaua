<div class="prev-catalog__other">
    @forelse ($items as $item)
        <a class="card__link card__link--other" href="{{ $item->link ?? '#' }}" title="{{ $getTitle }}">
            <figure class="card__wrap-img ie">
                <picture>
                    <source srcset="{{ $getWebp($item->image) }}" type="image/webp">
                    <img src="{{ $item->image }}" alt="{{ $item->name ?? $item->button_name }}">
                </picture>
            </figure>
            <div class="card__title">{{ $item->button_name }}</div>
        </a>
    @empty
    @endforelse
</div>
