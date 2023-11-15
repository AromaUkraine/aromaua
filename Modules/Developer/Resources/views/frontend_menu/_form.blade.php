<x-tab-lang :model="$menu" >

    <x-input
        :model="$menu"
        name="name"
        lang
        label="{{__('cms.root_menu_name')}}"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.root_menu_name'), 'required'=>true ]) !!}"
    ></x-input>

    <x-input
        :model="$menu"
        name="type"
        label="{{__('cms.root_menu_unique_key')}}"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.root_menu_unique_key'), 'required'=>true ]) !!}"
    ></x-input>

    <x-input
        :model="$menu"
        name="from"
        value="{{ \App\Models\Menu::FRONTEND }}"
        label="{{__('cms.menu_from')}}"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.menu_from'), 'required'=>true ]) !!}"
    ></x-input>

    <x-input
        :model="$menu"
        label="{{__('cms.icon')}}"
        value="fas fa-folder"
        name="icon"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.icon'), 'hint'=>__('cms.for_example').' fa fa-user' ]) !!}"
    ></x-input>

</x-tab-lang>

@section('form-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize my-2 mr-1"
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('developer.frontend_menu_root.index') }}"
        class="light text-capitalize my-2"
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection
