<x-tab-lang :model="$language">
    <x-input
        :model="$language"
        label="{{__('language.name')}}"
        name="name"
        lang
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('language.name'), 'required'=>true ]) !!}"
    ></x-input>
    <x-input
        :model="$language"
        label="{{__('language.short_name')}}"
        name="short_name"
        lang
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('language.short_name'), 'required'=>true ]) !!}"
    ></x-input>
    <x-input
        :model="$language"
        label="{{__('language.short_code')}}"
        name="short_code"
        options="{!! json_encode(['maxlength'=>3, 'placeholder'=>__('language.short_code'), 'required'=>true , 'readonly'=>($language->short_code) ?? false ]) !!}"
    ></x-input>
</x-tab-lang>

@section('form-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize mr-1"
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('admin.language.index') }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection

