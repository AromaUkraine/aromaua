
@if($setting)
    <x-tab-lang :model="$setting">
        <x-settings-value :model="$setting"></x-settings-value>
    </x-tab-lang>
@endif

@if(request()->user()->hasRole($roles))

    <x-input
        :model="$setting"
        label="{{__('cms.settings_name')}}"
        name="name"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.settings_name'), 'required'=>true ]) !!}"
    ></x-input>

    @if(!$setting)
        <x-slug-generator
            :model="$setting"
            name="key"
            label="{{__('cms.settings_key')}}"
            watch="name"
            options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.settings_key'), 'required'=>true ]) !!}"
        >
        </x-slug-generator>
    @else
        <x-input
            :model="$setting"
            label="{{__('cms.settings_key')}}"
            name="key"
            options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.settings_key'), 'required'=>true ]) !!}"
        ></x-input>
    @endif

    <x-input
        :model="$setting"
        label="{{__('cms.settings_component')}}"
        name="component"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.settings_component'), 'required'=>true ]) !!}"
    ></x-input>

    <x-input
        :model="$setting"
        label="{{__('cms.settings_group')}}"
        name="group"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.settings_group') ]) !!}"
    ></x-input>

@else
    <input type="hidden" name="component" value="{{$setting->component}}">
    <input type="hidden" name="key" value="{{$setting->key}}">
@endif

@section('form-fixed-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize my-2 mr-1"
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('root.settings.index') }}"
        class="light text-capitalize my-2"
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection
