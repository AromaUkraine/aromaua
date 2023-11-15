
<x-tab-lang :model="$category" rel="page" >

    @slot('language_switcher')
        <x-switcher
            :model="$category"
            rel="page"
            name="publish"
            lang
            label="{{ __('cms.publish') }}"
            options="{!! json_encode(['class'=>'float-right']) !!}"
        ></x-switcher>
    @endslot

    <x-input
        :model="$category"
        rel="page"
        name="name"
        lang
        label="{{__('page.name')}}"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('page.name'), 'required'=>true ]) !!}"
    ></x-input>

    <x-slug-generator
        :model="$category"
        rel="page"
        name="slug"
        lang
        label="{{__('cms.slug')}}"
        watch="name"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.slug'), 'required'=>true ]) !!}"
    >
    </x-slug-generator>

    <x-textarea
        :model="$category"
        rel="page"
        name="description"
        lang
        label="{{__('page.description')}}"
        options="{!! json_encode(['maxlength'=>255 ]) !!}"
    ></x-textarea>

    <x-editor
        :model="$category"
        rel="page"
        name="text"
        lang
        label="{{__('page.text')}}"
    ></x-editor>

    <x-seo-page :model="$category" rel="page"></x-seo-page>

</x-tab-lang>


@section('form-fixed-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize my-2 mr-1"
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('module.article_category.index', $page->id) }}"
        class="light text-capitalize my-2"
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection


