@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'entity'=> $entity , 'last'=>['name'=>$banner->name ?? 'cms.edit']]) }}

@section('actions')
    <x-action
        href="{{ route('module.entity_banner.index', [$table, $id]) }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row ">
        <div class="col-12">
            <x-card expand>
                <x-nav-inner-entity :entity="$entity"
                                    form="{!! json_encode( [ 'route' => ['module.entity_banner.update', [$table, $id, $banner->id] ] ]) !!}" >
                    @include('banner::cms.entity_banner._form',['banner'=>$banner ])
                </x-nav-inner-entity>
            </x-card>
        </div>
    </div>
@endsection
