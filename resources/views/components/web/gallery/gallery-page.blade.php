<div class="gallery js-gallery">
    <div class="gallery__container">
        @forelse ($items as $item)
            <div class="gallery__item">
                <a class="gallery__link ie" href="{{ $getBigImage($item->image) }}">
                    <picture>
                        <source srcset="{{  $getWebp($item->image) }}" type="image/webp">
                        <img class="gallery__img" src="{{ $item->image }}" alt="{{ $item->alt }}">
                    </picture>
                </a>
            </div>
        @empty
        @endforelse
    </div>
</div>

