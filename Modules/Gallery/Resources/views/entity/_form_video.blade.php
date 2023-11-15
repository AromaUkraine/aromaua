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

    <div class="row">
        <div class="col-md-7">
            <img src="{{ asset('images/cms/example-youtube.png') }}" alt="">
        </div>
        <div class="col-md-5">
            @if($gallery)
                <x-image
                    :model="$gallery"
                    name="image"
                    value="{!!  json_encode([$gallery->image]) !!}"
                    label="{{ __('cms.gallery_image') }}"
                    options="{!! json_encode(['required'=>true]) !!}"
                ></x-image>
            @else
                <x-image
                    :model="$gallery"
                    name="image"
                    label="{{ __('cms.gallery_image') }}"
                    options="{!! json_encode(['required'=>true]) !!}"
                ></x-image>
            @endif

        </div>
    </div>

    <x-input
        :model="$gallery"
        name="link"
        label="cms.gallery_link_to_youtube"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.gallery_link_to_youtube'), 'required'=>true]) !!}"
    >
    </x-input>


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
        name="type"
        type="hidden"
        value="{{ \Modules\Gallery\Entities\Gallery::TYPE_VIDEO }}"
        options="{!! json_encode(['class'=>'hidden']) !!}"
    >
    </x-input>

</x-tab-lang>


@section('form-fixed-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize my-2 mr-1"
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('module.entity_gallery.index', [$page->id, $table, $id ]) }}"
        class="light text-capitalize my-2"
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection

@push('scripts')
    <script>
        $(function(){
            let link = $('#link');

            link.change(function(e){
                $.loader('show');

                let preview = parseLink($(this).val());

                if(preview){
                    fm_youtube_preview('dz-image-image', preview);
                }
                $.loader('hide');
            })
            function parseLink(value) {

                var regExp = /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
                var match = value.match(regExp);

                if(match && match[2].length == 11 ){
                    value = `http://i3.ytimg.com/vi/${match[2]}/hqdefault.jpg`;
                    return value;
                }else{
                    return null;
                }
            }

        })
    </script>
@endpush
