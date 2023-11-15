
<div class="form-group">
    <label for="fmimage">Галлерея</label>
    <div class="dropzone dz-clickable" id="multiple-file" {{ $options }}>
        <div class="dz-message">{{__('filemanager.Select images')}} </div>

        <input type="text" class="dz-input" id="dz-gallery" style="width: 100%" value="{{ json_encode($src) ?? ''}}"
               name="{{$name}}"/>
        <div class="modal fade bd-example-modal-lg dz-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body"
                         data-url="@filemanager_get_resource(dialog.php)?{{ $params }}&akey=@filemanager_get_key()">
                        gallery
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success apply"
                                style="display: none">{{__('cms.buttons.select')}}</button>
                        <button type="button" class="btn btn-light"
                                data-dismiss="modal">{{__('cms.buttons.close')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $('.dropzone#multiple-file').fmdropzone({
            item: 'thumbs',
            type: 'multiple',
            base_url: "{{config('rfm.base_url')}}",
            image_base_path: "{{config('rfm.upload_dir')}}",
            thumbs_base_path: "/{{config('rfm.thumbs_base_path')}}",
        })
    </script>
@endpush
