<x-textarea
    :model="$model"
    name="value"
    label="{{ __('cms.settings_value') }}"
    lang
    options="{!! json_encode(['class'=>'setting-textarea']) !!}"
>
</x-textarea>
