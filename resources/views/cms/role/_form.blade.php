
<x-input
    :model="$role"
    label="{{__('role.name')}}"
    name="name"
    options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('role.name'), 'required'=>true ]) !!}"
></x-input>

@if($role)
    <x-input
        :model="$role"
        label="{{__('role.slug')}}"
        name="slug"
        :maxlength="255"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('role.slug'), 'required'=>true, 'readonly'=>true ]) !!}"
    ></x-input>
@else
    <x-select
        :model="$role"
        label="{{__('role.slug')}}"
        name="slug"
        options="{!! json_encode(['type'=>'select2', 'placeholder'=>__('cms.select.default'), 'required'=>true]) !!}"
    >
        @forelse($roles as $item)
            <option value="{{$item}}"> {{ $item }} </option>
        @empty
            <option value=""></option>
        @endforelse
    </x-select>
@endif

<x-textarea
    :model="$role"
    label="{{__('cms.description')}}"
    name="description"
    options="{!! json_encode(['maxlength'=>255 ]) !!}"
></x-textarea>

@section('form-buttons')
    <x-button
            type="submit"
            class="primary text-capitalize mr-1"
            title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
            href="{{ route('admin.role.index') }}"
            class="light text-capitalize"
            title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection

