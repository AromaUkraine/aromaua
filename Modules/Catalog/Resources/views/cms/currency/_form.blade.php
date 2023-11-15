<x-tab-lang :model="$currency" >

    <x-input
        :model="$currency"
        name="name"
        lang
        label="{{__('currency.name')}}"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('currency.name'), 'required'=>true ]) !!}"
    ></x-input>

    <x-input
        :model="$currency"
        name="short_name"
        lang
        label="{{__('currency.short_name')}}"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('currency.short_name'), 'required'=>true ]) !!}"
    ></x-input>

    <x-input
        :model="$currency"
        name="iso"
        label="{{__('currency.iso')}}"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('currency.iso')]) !!}"
    ></x-input>

    <x-input
        :model="$currency"
        name="html_code"
        label="{{__('currency.html_code')}}"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('currency.html_code')]) !!}"
    ></x-input>

    <x-input
        :model="$currency"
        name="unicode"
        label="{{__('currency.unicode')}}"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('currency.unicode')]) !!}"
    ></x-input>

</x-tab-lang>

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
