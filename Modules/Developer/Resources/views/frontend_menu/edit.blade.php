@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'last'=>[ 'name'=> $menu->name ] ]) }}

@section('actions')
    <x-action
        href="{{ route('developer.frontend_menu_root.create') }}"
        class="success text-capitalize mr-1"
        title="{{__('cms.buttons.create')}}"
        icon="bx bx-plus"></x-action>
    <x-action
        href="{{ route('developer.frontend_menu_root.index') }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row">
        <div class="col-6">
            <x-form expand options="{!! json_encode(['route'=>['developer.frontend_menu_root.update', $menu->id],  'method'=>'patch']) !!}" >
                @include('developer::frontend_menu._form')
            </x-form>
        </div>
    </div>
@endsection




