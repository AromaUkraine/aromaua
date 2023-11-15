
@if($languages)
@foreach($languages as $lang)

    <div class="form-group lang"
         @if($lang->short_code !== $default_language) style="display: none" @endif
         data-lang="{{$lang->short_code}}"
    >
        @if($label) <label for="{{ $setId($lang->short_code) }}">{{$label}} @isset($options['required']) * @endisset </label> @endif
        <div class="dropzone dz-clickable dropzone__multiple" id="multiple-file-{{$lang->short_code}}" {{ $getSize() }}>
            <div class="dz-message">{{__('cms.filemanager_select_images')}} </div>

            <input type="text"
                   class="dz-input"
                   id="dz-gallery-{{ $lang->short_code }}"
                   name="{{ $setName($lang->short_code) }}"
                   value="{{ $setJsonValue($lang->short_code) }}"
            />
            <div class="modal fade bd-example-modal-lg dz-modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body"
                             data-url="@filemanager_get_resource(dialog.php)?type=1&relative_url=1&lang=ru&&field_id=dz-gallery-{{ $setName($lang->short_code) }}&multiple=1&callback=fm_callback&akey=@filemanager_get_key()">
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
        <div class="col-10 float-left pl-0">
            @error( $lang->short_code.".".$name )
            <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong> </span>
            @enderror
        </div>
        @if(!$errors->has($lang->short_code.".".$name) && isset($options['hint']))
            <div class="col-10 float-left pl-0">
                <small class="text-muted">{!! $options['hint'] !!}</small>
            </div>
        @endif
    </div>

@endforeach
@else

<div class="form-group ">
    @if($label) <label for="{{ $setId() }}">{{$label}} @isset($options['required']) * @endisset </label> @endif
    <div class="dropzone dz-clickable dropzone__multiple" id="multiple-file-{{$setName()}}" {{ $getSize() }}>
        <div class="dz-message">{{__('cms.filemanager_select_images')}} </div>
        <input type="text"
               class="dz-input"
               id="dz-gallery-{{ $setName() }}"
               name="{{ $setName() }}"
               value="{{ $setValue() }}"
        />
        <div class="modal fade bd-example-modal-lg dz-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body"
                         data-url="@filemanager_get_resource(dialog.php)?type=1&relative_url=1&lang=ru&&field_id=dz-gallery-{{$setName()}}&multiple=1&callback=fm_callback&akey=@filemanager_get_key()">
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
    <div class="col-10 float-left pl-0">
        @error( $name )
        <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong> </span>
        @enderror
    </div>
    @if(!$errors->has($name) && isset($options['hint']))
        <div class="col-10 float-left pl-0">
            <small class="text-muted">{!! $options['hint'] !!}</small>
        </div>
    @endif
</div>

@endif

@include('components.cms.fields.scripts.multiple-'.$filemanager, ['languages'=>$languages ?? null])


