@extends('layouts.cms')

{{ Breadcrumbs::make([ 'last'=>['name'=>$shop->name] ]) }}

@section('actions')
    <x-action
        href="{{ route('root.shop.create') }}"
        class="success text-capitalize mr-1"
        title="{{__('cms.buttons.create')}}"
        icon="bx bx-plus"></x-action>
    <x-action
        href="{{ route('root.shop.index') }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection


@section('content')
    <div class="row ">
        <div class="col-12">
            <x-card expand>
                <x-nav-entity :entity="$shop" form="{!! json_encode(['route' => ['root.shop.update', $shop->id] ]) !!} ">
                    @include('shop::shop._form')
                </x-nav-entity>
            </x-card>
        </div>
    </div>
@endsection
