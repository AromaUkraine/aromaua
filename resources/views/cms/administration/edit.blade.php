@extends('layouts.cms')

{{--{{ \Breadcrumbs::make([ 'last'=>[ 'name'=>$user->role->name ] ]) }}--}}

@section('actions')
    <x-action
        href="{{ route('admin.administration.create') }}"
        class="success text-capitalize mr-1"
        title="{{__('cms.buttons.create')}}"
        icon="bx bx-plus"></x-action>
    <x-action
        href="{{ route('admin.administration.index') }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-6">
            <x-form expand options="{!! json_encode(['route' => ['admin.administration.update', $user->id],  'method'=>'patch']) !!}">
                @include('cms.administration._form')

            </x-form>
        </div>
        <div class="col-12 col-md-6">
            <x-form expand options="{!! json_encode(['route' => ['admin.administration.change_password', $user->id],  'method'=>'patch']) !!}">
                @include('cms.administration._change_password_form')
            </x-form>
        </div>

        @if($user->role->slug === \App\Models\Role::API_ROLE)
            <div class="col-12 col-md-6">
                <x-form  options="{!! json_encode(['route' => ['admin.administration.api_token', $user->id],  'method'=>'post']) !!}">
                    @include('cms.administration._api_token_form')
                </x-form>
            </div>
        @endif
    </div>
@endsection




