@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'entity'=> $entity ]) }}


@section('content')
    <div class="row">
        <div class="col-12">
            <x-card expand>
                <x-nav-inner-entity :entity="$entity" >
                    <x-entity-map :model="$entity" table="{{$table}}" id="{{$id}}"></x-entity-map>
                </x-nav-inner-entity>
            </x-card>
        </div>
    </div>
@endsection


