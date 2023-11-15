<x-tab-lang :model="$info">

    @slot('language_switcher')
        <x-switcher
            :model="$info"
            name="publish"
            lang
            label="{{ __('cms.publish') }}"
            options="{!! json_encode(['class'=>'float-right']) !!}"
        ></x-switcher>
    @endslot

    <x-input
        :model="$info"
        name="title"
        lang
        label="{{__('cms.information_title')}}"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.information_title'), 'required'=>true ]) !!}"
    ></x-input>

    <x-input
        :model="$info"
        name="type"
        label="{{__('cms.information_type')}}"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.information_type'), 'required'=>true ]) !!}"
    >
    </x-input>

    <x-textarea
        :model="$info"
        name="description"
        lang
        label="{{__('cms.information_description')}}"
    ></x-textarea>

</x-tab-lang>

@section('form-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize  mr-1"
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('module.page_info.index', [$page->id, $pageComponent->alias]) }}"
        class="light text-capitalize "
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection
