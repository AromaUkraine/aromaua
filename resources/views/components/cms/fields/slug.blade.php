<div
    class="form-group
    @if($slugable) slugable @endif
    @if($lang) lang @endif
    @if($maxlength) maxlength @endif"
    @if(isset($lang) && $lang !== $default_language) style="display: none" @endif
    @if(isset($lang)) data-lang="{{$lang}}"  @endif
>
    <label for="{{ $name }}">{{$label}}@if($required) * @endif</label>
    <input type="{{$type}}"
           @if($lang)
           class="form-control {{$class}} @error( $attr ) is-invalid @enderror"
           @else
           class="form-control {{$class}} @error( $name ) is-invalid @enderror"
           @endif
           id="{{ $id }}"
           name="{{ $name }}"
           value="{{ $value }}"
           @if($placeholder) placeholder="{{ \StringHelper::upper($placeholder) }}" @endif
           @if($maxlength) maxlength="{{$maxlength}}" @endif
           @if($required) required  @endif
           @if($readonly) readonly @endif
           @if($disabled) disabled @endif
    >

    @if($hint && $maxlength)
        <div class="col-11 float-left pl-0">
            <small class="text-muted">{{ $hint }}</small>
        </div>
        <div class="col-1 float-right pr-0 ">
            <div class="counter float-right " data-val-length="parent"></div>
        </div>
    @elseif(!$hint && $maxlength)
        <div class="col-11 float-left pl-0">
            @if($lang)
                @error( $attr )
                <span class="invalid-feedback d-block"  role="alert"><strong >{{ $message }}</strong> </span>
                @enderror
            @else
                @error( $name )
                <span class="invalid-feedback d-block"  role="alert"><strong >{{ $message }}</strong> </span>
                @enderror
            @endif
        </div>
        <div class="col-1 float-right pr-0 ">
            <div class="counter float-right " data-val-length="parent"></div>
        </div>
    @elseif($hint && !$maxlength)
        <div class="col-11 float-left pl-0">
            <small class="text-muted">{{ $hint }}</small>
        </div>
        <div class="col-12 float-left pl-0">
            @if($lang)
                @error( $attr )
                <span class="invalid-feedback d-block"  role="alert"><strong >{{ $message }}</strong> </span>
                @enderror
            @else
                @error( $name )
                <span class="invalid-feedback d-block"  role="alert"><strong >{{ $message }}</strong> </span>
                @enderror
            @endif
        </div>
    @else
        <div class="col-12 float-left pl-0">
            @if($lang)
                @error( $attr )
                <span class="invalid-feedback d-block"  role="alert"><strong >{{ $message }}</strong> </span>
                @enderror
            @else
                @error( $name )
                <span class="invalid-feedback d-block"  role="alert"><strong >{{ $message }}</strong> </span>
                @enderror
            @endif
        </div>
    @endif
</div>

@push('scripts')
{{--    <script>--}}
{{--        $(function(){--}}
{{--            $('.slugable').setslug({--}}
{{--                'watch' : '{{$slugable}}'--}}
{{--            });--}}


{{--        });--}}
{{--        (function($){--}}

{{--            $.fn.setslug = function (options){--}}

{{--                let settings = $.extend(--}}
{{--                    {},--}}
{{--                    $.fn.setslug.defaults,--}}
{{--                    options--}}
{{--                );--}}
{{--                return this.each(function () {--}}
{{--                    let elem = $(this);--}}
{{--                    console.log(elem);--}}
{{--                    console.log(settings);--}}
{{--                })--}}
{{--            }--}}

{{--            $.fn.setslug.defaults = {};--}}
{{--        })(jQuery)--}}
{{--    </script>--}}
@endpush
