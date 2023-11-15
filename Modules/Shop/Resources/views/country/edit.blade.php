@extends('layouts.cms')

@section('actions')
    <x-action
        href="{{ route('root.country.create') }}"
        class="success text-capitalize  mr-1"
        title="{{__('cms.buttons.create')}}"
        icon="bx bx-plus"></x-action>
    <x-action
        href="{{ route('root.country.index') }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row">
        <div class="col-6 ">
            <x-form expand options="{!! json_encode(['route' => ['root.country.update', $country->id] , 'method'=>'patch' ]) !!} ">
                @include('shop::country._form')
            </x-form>
        </div>
    </div>
@endsection



