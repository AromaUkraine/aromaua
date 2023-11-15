<x-tab-lang :model="$feature" >
    @slot('language_switcher')
        <x-switcher
            :model="$feature"
            name="publish"
            lang
            label="{{ __('cms.publish') }}"
            options="{!! json_encode(['class'=>'float-right']) !!}"
        ></x-switcher>
    @endslot

    <x-input
        :model="$feature"
        name="name"
        lang
        label="{{__('kind.name')}}"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('kind.name'), 'required'=>true ]) !!}"
    ></x-input>

    <x-catalog-cms-feature-kind-item-list :model="$feature"></x-catalog-cms-feature-kind-item-list>

    <x-switcher
        :model="$feature"
        name="filter"
        label="{{ __('kind.use_in_filter') }}"
        options="{!! json_encode(['class'=>'float-right']) !!}"
    ></x-switcher>

    <x-switcher
        :model="$feature"
        name="preview"
        label="{{ __('kind.use_in_preview') }}"
        options="{!! json_encode(['class'=>'float-right']) !!}"
    ></x-switcher>

    <x-switcher
        :model="$feature"
        name="page"
        label="{{ __('kind.use_in_page') }}"
        options="{!! json_encode(['class'=>'float-right']) !!}"
    ></x-switcher>

</x-tab-lang>

@section('form-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize  mr-1"
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('catalog.feature.index') }}"
        class="light text-capitalize "
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection
