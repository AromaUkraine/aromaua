
<x-tab-lang :model="$page">

    @slot('language_switcher')
        <x-switcher
            :model="$page"
            name="publish"
            lang
            label="{{ __('cms.publish') }}"
            options="{!! json_encode(['class'=>'float-right']) !!}"
        ></x-switcher>
    @endslot

    <x-input
        :model="$page"
        name="name"
        lang
        label="{{__('page.name')}}"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('page.name'), 'required'=>true ]) !!}"
    ></x-input>

    {{-- отключаем редактирование url-адреса главной страницы --}}
     @if($page->pageable->is_main)
         <x-input
             :model="$page"
             name="slug"
             lang
             value="main"
             label="{{__('cms.slug')}}"
             options="{!! json_encode(['readonly'=>true, 'required'=>true ]) !!}"
         ></x-input>
     @else
            <x-slug-generator
                :model="$page"
                name="slug"
                lang
                label="{{__('cms.slug')}}"
                watch="name"
                options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.slug'), 'required'=>true ]) !!}"
            >
            </x-slug-generator>
     @endif


    <x-textarea
        :model="$page"
        name="description"
        lang
        label="{{__('page.description')}}"
        options="{!! json_encode(['maxlength'=>255 ]) !!}"
    ></x-textarea>

    <x-editor
        :model="$page"
        name="text"
        lang
        label="{{__('page.text')}}"
    ></x-editor>

    <x-seo-page :model="$page"></x-seo-page>


</x-tab-lang>


@section('form-fixed-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize my-2 mr-1"
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('section.section.index') }}"
        class="light text-capitalize my-2"
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection

