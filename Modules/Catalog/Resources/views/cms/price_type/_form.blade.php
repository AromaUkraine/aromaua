
<x-catalog-cms-currency-item-list
    name="currency_id"
    value="{{ $type->currency->id ?? null }}"
></x-catalog-cms-currency-item-list>

<x-input
    :model="$type"
    name="name"
    label="{{__('price_type.name')}}"
    options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('price_type.name'), 'required'=>true ]) !!}"
></x-input>

<x-slug-generator
    :model="$type"
    name="key"
    label="{{__('price_type.key')}}"
    watch="name"
    options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('price_type.key'), 'required'=>true ]) !!}"
>
</x-slug-generator>

@section('form-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize mr-1"
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('catalog.product.index') }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection
