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



    @if(\Modules\Banner\Entities\Banner::types()->count())
        <br>
        <x-select
            name="type"
            label="{{ __('cms.banner_type') }}"
            options="{!! json_encode(['type'=>'select2 my-2', 'required'=>true]) !!}"
        >
            @foreach(\Modules\Banner\Entities\Banner::types() as $type)
                <option value="{{$type['value']}}" >{{$type['name']}}</option>
            @endforeach
        </x-select>
    @endif

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

    <x-textarea
        :model="$banner"
        name="description"
        lang
        label="{{__('cms.banner_description')}}"
    ></x-textarea>

</x-tab-lang>

@section('form-fixed-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize my-2 mr-1"
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('module.page_entity_banner.index', [$page->id, $table, $id]) }}"
        class="light text-capitalize my-2"
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection
