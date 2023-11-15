@if(!$gallery)
   {{-- При созднии галлереи только загрузка картинок --}}
    <x-gallery
        :model="$gallery"
        name="image"
        label="{{ __('cms.gallery') }}"
        options="{!! json_encode(['drop-zone-style'=>'height:auto;min-height:300px!important']) !!}"
    >
    </x-gallery>

@else

    <x-tab-lang :model="$gallery">

        @slot('language_switcher')
            <x-switcher
                :model="$gallery"
                name="publish"
                lang
                label="{{ __('cms.publish') }}"
                options="{!! json_encode(['class'=>'float-right']) !!}"
            ></x-switcher>
        @endslot

        <x-image
            :model="$gallery"
            name="image"
            label="{{ __('cms.gallery_image') }}"
            lang
            options="{!! json_encode(['required'=>true]) !!}"
        ></x-image>

        <x-input
            :model="$gallery"
            name="name"
            lang
            label="{{__('cms.gallery_name')}}"
            options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.gallery_name') ]) !!}"
        >
        </x-input>

        <x-input
            :model="$gallery"
            name="alt"
            lang
            label="{{__('cms.gallery_alt')}}"
            options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.gallery_alt') ]) !!}"
        >
        </x-input>

        <x-input
            :model="$gallery"
            name="active"
        >

        </x-input>

    </x-tab-lang>

@endif

@section('form-fixed-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize my-2 mr-1"
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('module.entity_gallery.index', [ $page->id, $table, $id ]) }}"
        class="light text-capitalize my-2"
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection
