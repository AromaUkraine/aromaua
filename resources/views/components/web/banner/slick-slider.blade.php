<section class="main-slider">
    <div class="main-slider__container" id="js-main-slider">
        @forelse($items as $item)

            <div class="main-slider__slide">
                <div class="main-slider__info">
                    @if(isset($item->name) && strlen($item->name))
                        <div class="main-slider__title">{!! $item->name !!}</div>
                    @endif
                    @if(isset($item->description) &&  strlen($item->description))
                        <p class="main-slider__text"> {!! $stripTags($item->description) !!} </p>
                    @endif
                    @if($item->link && $item->button_name )
                        <a class="btn" href="{{ $item->link ?? '#' }}" title="{{ $getTitle }}">{{ $item->button_name }}</a>
                    @endif
                </div>
                <figure class="main-slider__wrap-img ie">
                    <picture>
                        <source srcset="{{ $getWebp($item->image) }}" type="image/webp">
                        <img class="main-slider__img" src="{{ $setImageOrDefault($item,'image') }}" alt="{{ $item->name }}">
                    </picture>
                </figure>
            </div>
        @empty
        @endforelse
    </div>
</section>
