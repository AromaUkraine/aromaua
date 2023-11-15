
<x-tab-lang :model="$contact">
    @slot('language_switcher')
        <x-switcher
            :model="$contact"
            name="publish"
            lang
            label="{{ __('cms.publish') }}"
            options="{!! json_encode(['class'=>'float-right']) !!}"
        ></x-switcher>
    @endslot

    <x-contact-type-list
        :model="$contact"
        label="{{__('cms.select_contact_type')}}"
        name="type"
        options="{!! json_encode(['type'=>'select2','required'=>true, 'placeholder'=>__('cms.select.default'),])!!}"
    > </x-contact-type-list>

    <x-input
        :model="$contact"
        label="{{__('cms.entity_contact_value')}}"
        name="value"
        options="{!! json_encode(['required'=>true,'maxlength'=>255 ])!!}"
    ></x-input>

    <x-input
        :model="$contact"
        label="{{__('cms.contact_description')}}"
        name="description"
        lang
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.contact_description') ]) !!}"
    >
    </x-input>

</x-tab-lang>


@section('form-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize  mr-1"
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('module.entity_contact.index', [$table, $id]) }}"
        class="light text-capitalize m"
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection
