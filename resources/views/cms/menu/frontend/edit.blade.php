@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'last'=>[ 'name'=> $menu->name ] ]) }}

@section('actions')

    <x-action
        href="{{ route('root.frontend_menu.index') }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row">
        <div class="col-6">
            <x-form expand options="{!! json_encode(['route'=>['root.frontend_menu.update', $menu->id],  'method'=>'patch']) !!} " >
                @include('cms.menu.frontend._form')
            </x-form>
        </div>
    </div>
@endsection

