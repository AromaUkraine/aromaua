<x-input-number
    label="{{ $label }}"
    name="{{ $name }}"
    value="{{ $value }}"
    options="{!! json_encode(['min'=>0,'max'=>100000,'step'=>1, 'decimals'=>2]) !!}"
>
</x-input-number>
