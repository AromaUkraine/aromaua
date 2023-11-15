
<x-input
    :model="$user"
    label="{{__('user.name')}}"
    name="login"
    options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('user.name'), 'required'=>true ]) !!}"
></x-input>

<x-input
    :model="$user"
    label="{{__('user.email')}}"
    name="email"
    options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('user.email'), 'type'=>'email', 'required'=>true ]) !!}"
></x-input>

@if(!$user)
    <x-input
        :model="$user"
        label="{{__('user.password')}}"
        name="password"
        options="{!! json_encode([
        'placeholder'=>__('user.password'),
        'required'=>true,
        'type'=>'password',
        'autocomplete'=>'password_confirmation',
        'hint'=>'Minimum of 8 characters'
        ]) !!}"
    ></x-input>
    <x-input
        :model="$user"
        label="{{__('user.confirm_password')}}"
        name="password_confirmation"
        options="{!! json_encode(['placeholder'=>__('user.confirm_password'), 'type'=>'password', 'required'=>true]) !!}"
    ></x-input>
@endif

<x-select
    :model="$user"
    label="{{__('user.roles')}}"
    name="role_id"
    options="{!! json_encode(['type'=>'select2', 'placeholder'=>__('cms.select.default'), 'required'=>true]) !!}"
>
    @foreach($roles as $role)
        @if(isset($user->roles) && $user->roles[0]->id == $role->id)
            <option value="{{$role->id}}" selected> {{ $role->name }} </option>
        @else
            <option value="{{$role->id}}"> {{ $role->name }} </option>
        @endif
    @endforeach
</x-select>

@section('form-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize mr-1"
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('admin.administration.index') }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection

