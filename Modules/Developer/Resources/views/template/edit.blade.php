@extends('layouts.cms')

@section('actions')
    <x-action
        href="{{ route('developer.template.create') }}"
        class="success text-capitalize  mr-1"
        title="{{__('cms.buttons.create')}}"
        icon="bx bx-plus"></x-action>
    <x-action
        href="{{ route('developer.template.index') }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 ">
            <x-form expand options="{!! json_encode(['route' => ['developer.template.update', $template->id] , 'method'=>'patch' ]) !!} ">
                @include('developer::template._form')
            </x-form>
        </div>
    </div>
@endsection



