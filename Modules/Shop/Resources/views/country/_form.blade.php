<x-tab-lang :model="$country">
    @slot('language_switcher')
        <x-switcher
            :model="$country"
            name="publish"
            lang
            label="{{ __('cms.publish') }}"
            options="{!! json_encode(['class'=>'float-right']) !!}"
        ></x-switcher>
    @endslot

    <x-input
        :model="$country"
        label="{{__('cms.country_name')}}"
        name="name"
        lang
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.country_name'), 'required'=>true ]) !!}"
    ></x-input>

</x-tab-lang>

@section('form-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize mr-1"
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('root.country.index') }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection
