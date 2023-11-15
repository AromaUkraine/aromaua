<x-color-picker
    :model="$model"
    name="color_scheme_id"
    label="{{__('cms.select_color')}}"
    lang="{{$lang}}"
    options="{!! $options !!}"
>
</x-color-picker>

<div class="test"></div>
<x-input
    :model="$model"
    name="{{$name}}"
    lang="{{$lang}}"
    label="{{$label}}"
    options="{!! $options !!}"
></x-input>

@push('scripts')
    <script>
        $('#color_scheme_id').change(function (e){
            let data = {
                'url': '{{route('get-feature-value-name')}}',
                'data': {color_scheme_id:e.target.value },
                'type':'POST',
                'dataType':'json'
            }
            $.sendAjax(data,function (response){
                $.each(response, function(lang, data) {
                    let inputName = $(`#${lang}_name`);
                    if(typeof inputName !== typeof undefined ){
                        inputName.val(data.name);
                    }
                })
            });
        })
    </script>
@endpush
