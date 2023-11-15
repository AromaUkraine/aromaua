<x-tab-lang :model="$page" >

    <x-input
        :model="$page"
        name="name"
        lang
        label="{{__('page.name')}}"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('page.name'), 'required'=>true ]) !!}"

    ></x-input>

   {{-- исключаем редактирование url-адреса главной страницы и шаблона --}}
    @if($page && $page->pageable->is_main)

        <x-input
            lang
            name="slug"
            value="main"
            options="{!! json_encode(['readonly'=>true]) !!}"
        >
        </x-input>
        <x-input
            name="template_id"
            value="{{$page->pageable->id}}"
            options="{!! json_encode(['readonly'=>true, 'class'=>'hidden']) !!}"
        >
        </x-input>

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
        <x-template-list
            :model="$page"
            label="{{__('page.template')}}"
            name="template_id"
            options="{!! json_encode([
            'type'=>'select2',
            'placeholder'=>__('cms.select.default'),
            'required'=>true,

        ]) !!}"
        ></x-template-list>
    @endif



</x-tab-lang>

@section('form-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize my-2 mr-1"
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('developer.page.index') }}"
        class="light text-capitalize my-2"
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection
