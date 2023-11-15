


<div class="form-group">
    <label for="fmimage">Загрузить фото</label>
    <div class="dropzone dz-clickable dropzone__single" id="single-file" {{ $options }}>
        <div class="dz-message" >{{__('filemanager.Select image')}} </div>
        <input type="text" class="dz-input " id="dz-image"  value="{{ json_encode($src) ?? ''}}" name="{{$name}}" />
        <div class="modal fade bd-example-modal-lg dz-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body" data-url="@filemanager_get_resource(dialog.php)?{{ $params }}&akey=@filemanager_get_key()">
                        simple
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">{{__('cms.buttons.close')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
         $('.dropzone#single-file').fmdropzone({
             item:'image',
             base_url: "{{config('rfm.base_url')}}",
             image_base_path: "{{config('rfm.upload_dir')}}",
             thumbs_base_path: "/{{config('rfm.thumbs_base_path')}}",
         });
    </script>
@endpush
