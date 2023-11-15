<div class="advantages">
    <div class="advantages__container">
        @forelse ($info as $item)
            <div class="advantages__item">
                <figure class="advantages__wrap-icon">
                    <svg class="svg-sprite advantages__icon" width="109px" height="76px">
                        <use xlink:href="{{ asset('images/web/svg/symbol/sprite.svg#advantages-'.$loop->iteration) }}"></use>
                    </svg>
                </figure>
                <div class="advantages__info">
                    <p class="advantages__text">
                        <strong>{{ $item->title }}</strong> {{ $item->description }}
                    </p>
                </div>
            </div>
        @empty

        @endforelse

    </div>
</div>
