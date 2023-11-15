@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'last'=>[ 'name'=>$setting->name ] ]) }}

@section('actions')

    @role($roles)
        <x-action
            href="{{ route('root.settings.create') }}"
            class="success text-capitalize mr-1"
            title="{{__('cms.buttons.create')}}"
            icon="bx bx-plus"></x-action>
    @endrole

    <x-action
        href="{{ route('root.settings.index') }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>

@endsection


@section('content')
    <div class="row">
        <div class="col-6">
            <x-form expand options="{!! json_encode(['route' => ['root.settings.update', $setting->id],  'method'=>'patch']) !!}">
                @include('cms.settings._form')
            </x-form>
        </div>
    </div>
@endsection




