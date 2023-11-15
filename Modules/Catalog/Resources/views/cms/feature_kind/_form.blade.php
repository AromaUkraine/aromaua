<x-tab-lang :model="$kind">
    @slot('language_switcher')
        <x-switcher
            :model="$kind"
            name="publish"
            lang
            label="{{ __('cms.publish') }}"
            options="{!! json_encode(['class'=>'float-right']) !!}"
        ></x-switcher>
    @endslot

    <x-input
        :model="$kind"
        name="name"
        lang
        label="{{__('kind.name')}}"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('kind.name'), 'required'=>true ]) !!}"
    ></x-input>

    @if($kind)
        <x-input
            :model="$kind"
            name="key"
            label="{{__('kind.key')}}"
            options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('kind.key'), 'required'=>true, 'readonly'=>true ]) !!}"
        >
        </x-input>
    @else
        <x-slug-generator
            :model="$kind"
            name="key"
            label="{{__('kind.key')}}"
            watch="ru_name"
            options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('kind.key'), 'required'=>true,  ]) !!}"
        >
        </x-slug-generator>
    @endif


</x-tab-lang>

@section('form-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize  mr-1"
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('catalog.feature_kind.index') }}"
        class="light text-capitalize "
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection
