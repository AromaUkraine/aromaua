<x-tab-lang :model="$value" >
    @slot('language_switcher')
        <x-switcher
            :model="$value"
            name="publish"
            lang
            label="{{ __('cms.publish') }}"
            options="{!! json_encode(['class'=>'float-right']) !!}"
        ></x-switcher>
    @endslot

    <x-cms-catalog-feature-value-custom-input
        :model="$value"
        name="name"
        key="{{$kind->key}}"
        lang
        label="{{__('cms.feature_value_name')}}"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('kind.name'), 'required'=>true ]) !!}"
    ></x-cms-catalog-feature-value-custom-input>


</x-tab-lang>

@section('form-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize  mr-1"
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('module.feature_value.index', $kind->id) }}"
        class="light text-capitalize "
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection
