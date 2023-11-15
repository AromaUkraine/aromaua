@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'last'=>[ 'name'=> __('cms.new_record') ] ]) }}

@section('actions')
    <x-action
        href="{{ route('developer.entity_component.index') }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row ">
        <div class="col-12">
            <div class="row">
                <div class="col-6">
                    <x-form expand options="{!! json_encode(['route' => 'developer.entity_component.store', 'id'=>'entity_component']) !!} ">
                        @include('developer::entity_component._form',['item'=>null])
                    </x-form>
                </div>
                <div class="col-6">
                   @include('developer::entity_component.info')
                </div>
            </div>

        </div>
    </div>
@endsection





