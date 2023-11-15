@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'entity'=> $entity , 'last'=>['name'=>__('cms.new_record')]]) }}

@section('actions')
    <x-action
        href="{{ route('module.gallery.index', [$table, $id]) }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <x-card expand>
                <x-nav-inner-entity :entity="$entity"
                              form="{!! json_encode( [ 'route' => ['module.gallery.store', 'table'=>$table, 'id'=>$id,  'type'=>$type] ]) !!}" >
                    @include('gallery::default._form_'.$type,['gallery'=>null])
                </x-nav-inner-entity>
            </x-card>
        </div>
    </div>
@endsection
