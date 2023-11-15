<x-tab-lang :model="$shop">

    @slot('language_switcher')
        <x-switcher
            :model="$shop"
            name="publish"
            lang
            label="{{ __('cms.publish') }}"
            options="{!! json_encode(['class'=>'float-right']) !!}"
        ></x-switcher>
    @endslot

    <x-input
        :model="$shop"
        label="{{__('cms.shop_name')}}"
        name="name"
        lang
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.shop_name'), 'required'=>true ]) !!}"
    ></x-input>

    <x-shop-model-item-list
        :model="$shop"
        name="country_id"
        entity="{{ \Modules\Shop\Entities\Country::class }}"
        label="{{__('cms.country_list')}}"
    ></x-shop-model-item-list>

    <x-textarea
        :model="$shop"
        label="{{__('cms.shop_address')}}"
        name="address"
        lang
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.shop_address') ]) !!}"
    ></x-textarea>

    <x-textarea
        :model="$shop"
        label="{{__('cms.shop_address_decription')}}"
        name="info"
        lang
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.shop_address_decription') ]) !!}"
    ></x-textarea>


</x-tab-lang>

@section('form-fixed-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize my-2 mr-1"
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('root.shop.index') }}"
        class="light text-capitalize my-2"
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection
