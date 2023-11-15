@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'entity'=>$entity ,'last'=>['name'=>__('cms.new_record')] ]) }}

@section('actions')
    <x-action
        href="{{ route('module.entity_contact.index', [ $table, $id]) }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <x-card expand>
                <x-nav-inner-entity
                    :entity="$entity"
                    form="{!! json_encode( [ 'route' => ['module.entity_contact.store',  $table, $id ], 'method'=>'post']) !!}" >
                        @include('shop::entity_contact._form',['contact'=>null])
                </x-nav-inner-entity>
            </x-card>
        </div>
    </div>
@endsection
