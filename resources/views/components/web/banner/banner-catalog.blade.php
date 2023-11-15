
<section class="prev-catalog">
    <h2 class="prev-catalog__title h2">{{__('web.product_catalog')}}</h2>

    <div class="prev-catalog__cards cards">
    @foreach($items as $item)
            <div class="card">
                <a class="card__link" href="{{ $item->link ?? '#' }}" title="{{ $getTitle }}">
                    <figure class="card__wrap-img">
                        <picture>
                            <source srcset="{{ $getWebp($item->image) }}" type="image/webp">
                            <img src="{{ $item->image }}" alt="{{ $item->name ?? $item->button_name }}">
                        </picture>
                    </figure>
                    <div class="card__title">{{ $item->button_name }}</div>
                </a>
            </div>
    @endforeach
    </div>
    {{-- open second block --}}
    <div class="prev-catalog__bottom-block catalog-block">
        <div class="catalog-block__cards-form">
            {{-- open cards block --}}
            <div class="catalog-block__cards cards " >
            </div>
            {{-- close cards block --}}

            {{-- form block --}}
            <div class="catalog-block__wrap-form form-chouse">
                <v-form-help :show="true"></v-form-help>
            </div>
            {{-- end form block --}}

        </div>

        <x-banner-other-products key="other-products" :page="$page"></x-banner-other-products>
    </div>
</section>

