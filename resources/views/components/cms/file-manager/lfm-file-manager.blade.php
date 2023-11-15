@section('actions')
    <x-action
            href="#"
            class="success text-capitalize mr-1 show images"
            title="{{__('cms.images')}}"
            icon="bx bx-image"></x-action>
     <x-action
            href="#"
            class="warning text-capitalize show files"
            title="{{__('cms.files')}}"
            icon="bx bx-file"></x-action>        
@endsection

<iframe src="/cms/laravel-filemanager?type=images" 
id="lfm" 
data-url="/cms/laravel-filemanager" 
{{ $options  }}
name="lfm"
></iframe>
