@php $label = __("cms.settings_switcher-:item",['item'=>$model->key]) @endphp
<x-switcher
    :model="$model"
    name="value"
    label="{{ __($label) }}"
    lang
    options="{!! json_encode(['class'=>'setting-textarea']) !!}"
>
</x-switcher>
