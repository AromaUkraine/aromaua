@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'last'=>[ 'name'=> $feature->name ] ]) }}

@section('actions')
    <x-action
        href="{{ route('catalog.feature.create' ) }}"
        class="success text-capitalize  mr-1"
        title="{{__('cms.buttons.create')}}"
        icon="bx bx-plus"></x-action>
    <x-action
        href="{{ route('catalog.feature.index') }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row">
        <div class="col-6">
            <x-form expand options="{!! json_encode(['route' => ['catalog.feature.update', $feature->id], 'method'=>'patch' ]) !!} ">
                @include('catalog::cms.feature._form',['feature'=>$feature])
            </x-form>
        </div>
    </div>
@endsection

