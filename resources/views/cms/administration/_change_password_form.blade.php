
<x-input
    name="old_password"
    label="{{__('cms.old_password')}}"
    options="{!! json_encode(['type'=>'password']) !!}"
></x-input>

<x-input
    name="new_password"
    label="{{__('cms.new_password')}}"
    options="{!! json_encode(['type'=>'password', 'hint'=>__('cms.minimum password length 8 characters')]) !!}"
></x-input>

<x-input
    name="confirm_new_password"
    label="{{__('cms.confirm_new_password')}}"
    options="{!! json_encode(['type'=>'password']) !!}"
></x-input>

@section('form-buttons')
    <x-button
        type="submit"
        class="warning text-capitalize"
        title="{{__('cms.buttons.change')}}"
    ></x-button>
@overwrite
