<x-tab-lang :model="$menu">

    @slot('language_switcher')
        <x-switcher
            :model="$menu"
            name="publish"
            lang
            label="{{ __('cms.publish') }}"
            options="{!! json_encode(['class'=>'float-right']) !!}"
        ></x-switcher>
    @endslot


    <x-input
        :model="$menu"
        label="{{__('menu.name')}}"
        name="name"
        lang
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('menu.name'), 'required'=>true ]) !!}"
    ></x-input>

    <x-input
        :model="$menu"
        label="{{__('cms.icon')}}"
        name="icon"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.icon'), 'hint'=>__('cms.for_example').' fa fa-user' ]) !!}"
    ></x-input>

</x-tab-lang>

@section('form-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize mr-1"
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('root.frontend_menu.index') }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection
