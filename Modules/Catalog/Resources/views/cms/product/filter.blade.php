

{{-- <x-select
    name="order_price"
    label="{{ __('cms.sort_by_price') }}"
    options="{!! json_encode(['disable' => 1]) !!} ">
    <option value="desc">{{ __('cms.from expensive to cheap') }}</option>
    <option value="asc">{{ __('cms.from cheap to expensive') }}</option>
</x-select> --}}

<x-catalog-cms-product-category-item-list
    name="product_category"
></x-catalog-cms-product-category-item-list>

<x-input label="{{__('cms.card_code')}}" value="{{request()->get('code_1c')}}" name="code_1c"></x-input>

<x-input label="{{__('cms.product_code')}}" value="{{request()->get('product_code')}}" name="product_code"></x-input>

{{-- <x-input label="{{__('cms.code')}}" value="{{request()->get('code')}}" name="series"></x-input> --}}





