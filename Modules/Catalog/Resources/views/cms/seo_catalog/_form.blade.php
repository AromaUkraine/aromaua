<x-tab-lang :model="$seo" rel="page" >
    @slot('language_switcher')
        <x-switcher
            :model="$seo"
            rel="page"
            name="publish"
            lang
            label="{{ __('cms.publish') }}"
            options="{!! json_encode(['class'=>'float-right']) !!}"
        ></x-switcher>
    @endslot

    <x-input
        :model="$seo"
        rel="page"
        name="name"
        lang
        label="{{__('product.name')}}"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('product.name'), 'required'=>true ]) !!}"
    ></x-input>

    <x-slug-generator
        :model="$seo"
        rel="page"
        name="slug"
        lang
        label="{{__('cms.slug')}}"
        watch="name"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.slug'), 'required'=>true ]) !!}"
    >
    </x-slug-generator>

    <x-catalog-cms-page-component-item-list
        :model="$seo"
        name="parent_page_id"
    ></x-catalog-cms-page-component-item-list>

{{--    <x-catalog-cms-feature-kind-types :model="$seo" name="type">--}}
{{--    </x-catalog-cms-feature-kind-types>--}}

    <x-switcher
        :model="$seo"
        name="is_brand"
        label="Использовать как страницу бренда"
    ></x-switcher>

    <input type="hidden" name="product_category_id" value="{{$seo->product_category_id ?? null}}">

    <x-textarea
        :model="$seo"
        rel="page"
        name="description"
        lang
        label="{{__('page.description')}}"
    ></x-textarea>

    <x-editor
        :model="$seo"
        rel="page"
        name="text"
        lang
        label="{{__('page.text')}}"
    ></x-editor>

    <x-seo-page :model="$seo" rel="page"></x-seo-page>

</x-tab-lang>

@section('form-fixed-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize my-2 mr-1"
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('catalog.seo_catalog.index') }}"
        class="light text-capitalize my-2"
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection
