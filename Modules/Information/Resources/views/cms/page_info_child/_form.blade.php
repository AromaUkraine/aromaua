<x-tab-lang :model="$child">

    @slot('language_switcher')
        <x-switcher
            :model="$child"
            name="publish"
            lang
            label="{{ __('cms.publish') }}"
            options="{!! json_encode(['class'=>'float-right']) !!}"
        ></x-switcher>
    @endslot

    <x-input
        :model="$child"
        name="title"
        lang
        label="{{__('cms.information_title')}}"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.information_title'), 'required'=>true ]) !!}"
    ></x-input>


    <x-textarea
        :model="$child"
        name="description"
        lang
        label="{{__('cms.information_description')}}"
    ></x-textarea>

    <x-input
        :model="$child"
        name="icon"
        label="{{__('cms.information_icon')}}"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.information_icon')]) !!}"
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
        href="{{ route('module.page_info_child.index', [$page->id, $pageComponent->alias, $parent->id]) }}"
        class="light text-capitalize "
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection
