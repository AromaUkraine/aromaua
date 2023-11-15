
<x-tab-lang :model="$banner"  >

    @slot('language_switcher')
        <x-switcher
            :model="$banner"
            name="publish"
            lang
            label="{{ __('cms.publish') }}"
            options="{!! json_encode(['class'=>'float-right']) !!}"
        ></x-switcher>
    @endslot

    <x-image
        :model="$banner"
        name="image"
        label="{{ __('cms.banner_image') }}"
        lang
        options="{!! json_encode(['required'=>true]) !!}"
    ></x-image>

    <x-input
        :model="$banner"
        name="name"
        lang
        label="{{__('cms.banner_name')}}"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.banner_name') ]) !!}"
    ></x-input>

        <x-input
        :model="$banner"
        name="link"
        lang
        label="{{__('cms.banner_link')}}"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.banner_link') ]) !!}"
    ></x-input>

    <x-input
        :model="$banner"
        name="button_name"
        lang
        label="{{__('cms.banner_button_name')}}"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.banner_button_name') ]) !!}"
    ></x-input>

    <x-editor
        :model="$banner"
        name="description"
        lang
        label="{{__('cms.banner_description')}}"
    ></x-editor>

</x-tab-lang>

@section('form-fixed-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize my-2 mr-1"
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('module.page_banner.index', [$page->id, $alias]) }}"
        class="light text-capitalize my-2"
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection

