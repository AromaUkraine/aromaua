<x-tab-lang :model="$product" rel="page" >
    @slot('language_switcher')
        <x-switcher
            :model="$product"
            rel="page"
            name="publish"
            lang
            label="{{ __('cms.publish') }}"
            options="{!! json_encode(['class'=>'float-right']) !!}"
        ></x-switcher>
    @endslot

    <x-input
        :model="$product"
        rel="page"
        name="name"
        lang
        label="{{__('product.name')}}"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('product.name'), 'required'=>true ]) !!}"
    ></x-input>


    <x-slug-generator
        :model="$product"
        rel="page"
        name="slug"
        lang
        label="{{__('cms.slug')}}"
        watch="name"
        options="{!! json_encode(['maxlength'=>255,  'placeholder'=>__('cms.slug'), 'required'=>true ]) !!}"
    >
    </x-slug-generator>

    <x-catalog-cms-product-category-item-list
        :model="$product"
    >
    </x-catalog-cms-product-category-item-list>



    <x-input
        :model="$product"
        name="vendor_code"
        label="{{__('product.vendor_code')}}"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('product.vendor_code') ]) !!}"
    ></x-input>

    <x-input
        :model="$product"
        name="product_code"
        label="{{__('product.product_code')}}"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('product.product_code') ]) !!}"
    ></x-input>


{{--    @if(Nwidart\Modules\Facades\Module::has('Synchronize'))--}}
        {{-- <x-catalog-cms-product-price-type
            :model="$product"
        ></x-catalog-cms-product-price-type>

        <x-input-number
            :model="$product"
            name="price[value]"
            value="{{ $product ? $product->price->value : 0 }}"
            label="{{__('cms.product_price')}}"
            options="{!! json_encode(['min'=>0, 'max'=>100000, 'step'=>1, 'decimals'=>2, 'required'=>true, 'placeholder'=>__('cms.product_price')]) !!}"
        >
        </x-input-number> --}}
{{--    @endif--}}


    <x-textarea
        :model="$product"
        rel="page"
        name="description"
        lang
        label="{{__('page.description')}}"
    ></x-textarea>

    <x-editor
        :model="$product"
        rel="page"
        name="text"
        lang
        label="{{__('page.text')}}"
    ></x-editor>

    <x-seo-page :model="$product" rel="page"></x-seo-page>

</x-tab-lang>

@section('form-fixed-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize my-2 mr-1"
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('catalog.product.index') }}"
        class="light text-capitalize my-2"
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection
