@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'entity'=> $entity ]) }}

@section('content')
    <div class="row ">
        <div class="col-12">
            <x-card expand>
                <x-nav-inner-entity :entity="$entity"
                                    form="{!! json_encode( [ 'route' => ['module.feature_modify.update', 'table'=>$table, 'id'=>$id] ]) !!}" >
                    @include('catalog::cms.feature_modify._form')
                </x-nav-inner-entity>
            </x-card>
        </div>
    </div>
@endsection
