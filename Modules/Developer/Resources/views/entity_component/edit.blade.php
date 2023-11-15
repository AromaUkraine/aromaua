@extends('layouts.cms')

@section('actions')
    <x-action
        href="{{ route('developer.entity_component.index') }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 ">
            <div class="row">
                <div class="col-6">
                    <x-form expand options="{!! json_encode(['route' => ['developer.entity_component.update', $item->id] , 'method'=>'patch', 'id'=>'entity_component']) !!} ">
                        @include('developer::entity_component._form')
                    </x-form>
                </div>
                <div class="col-6">
                    @include('developer::entity_component.info')
                </div>
            </div>

        </div>
    </div>
@endsection

