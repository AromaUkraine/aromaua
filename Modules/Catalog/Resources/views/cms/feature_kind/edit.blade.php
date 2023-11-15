@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'last'=>[ 'name'=> $kind->name ] ]) }}

@section('actions')
    <x-action
        href="{{ route('catalog.feature_kind.create' ) }}"
        class="success text-capitalize  mr-1"
        title="{{__('cms.buttons.create')}}"
        icon="bx bx-plus"></x-action>
    <x-action
        href="{{ route('catalog.feature_kind.index') }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row">
        <div class="col-6">
            <x-form expand options="{!! json_encode(['route' => ['catalog.feature_kind.update', $kind->id], 'method'=>'patch' ]) !!} ">
                @include('catalog::cms.feature_kind._form',['kind'=>$kind])
            </x-form>
        </div>
    </div>
@endsection

