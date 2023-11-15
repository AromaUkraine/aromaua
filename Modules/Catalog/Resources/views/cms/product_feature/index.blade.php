@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'entity'=> $entity ]) }}

@section('content')
    <div class="row ">
        <div class="col-12">
            <x-card expand>
                <x-nav-entity :entity="$entity"
                              form="{!! json_encode( [ 'route' => ['module.product_feature.store', 'table'=>$table, 'id'=>$id] ]) !!}" >
                    @include('catalog::cms.product_feature._form')
                </x-nav-entity>
            </x-card>
        </div>
    </div>
@endsection
