<x-input
    :model="$template"
    label="{{__('template.name')}}"
    name="name"
    :maxlength="255"
    placeholder="{{__('template.name')}}"
    required>
</x-input>

@if($module)
    <x-input
        name="module"
        value="{{ $module['alias']}}"
        options="{!! json_encode(['readonly'=>true]) !!} "
    ></x-input>
@else
    @if(!$template || $template->type !== 'main')
        <x-select label="Modules" options="{!! json_encode(['type'=>'select2', 'placeholder'=>__('cms.select.default')]) !!}" name="module">
            @foreach ($modules as $item)
                <option value="{{ $item['alias'] }}">{{ $item['name'] }}</option>
            @endforeach
        </x-select>
    @endif
@endif

<x-input
    :model="$template"
    label="{{__('template.type')}}"
    name="type"
    :maxlength="255"
    placeholder="{{__('template.type')}}"
    options="{!! json_encode(['readonly'=>($template && $template->type =='main')]) !!}"
    required>
</x-input>

<x-drag-drop-left-right
    options="{!! json_encode([
    'left'=>[
        'label' => 'widgets.used',
        'data'  => $widgets['used'] ?? [],
        'name' => 'used'
    ],
    'right'=>[
        'label' => 'widgets.available',
        'data'  => $widgets['available'] ?? [],
    ],
    'search'=>true
]) !!}">
</x-drag-drop-left-right>


@section('form-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize mr-1"
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('developer.template.index') }}"
        class="light text-capitalize "
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection


@push('scripts')
    <script>
        var $eventSelect = $('select#module');
        var $inputType = $('input#type');
        $eventSelect.on("change", function (e) { $inputType.val(this.value) });
    </script>
@endpush
