@extends('layouts.cms')

{{ \Breadcrumbs::make(['entity'=>$entity ,'last'=>['name'=> 'cms.edit'] ]) }}

@section('actions')
    <x-action
        href="{{ route('module.entity_contact.index', [$table, $id]) }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row ">
        <div class="col-12">
            <x-card expand>
                <x-nav-inner-entity  :entity="$entity"
                                    form="{!! json_encode( [ 'route' => ['module.entity_contact.update', $table, $id, $contact->id] ]) !!}" >
                    @include('shop::entity_contact._form')
                </x-nav-inner-entity>
            </x-card>
        </div>
    </div>
@endsection
