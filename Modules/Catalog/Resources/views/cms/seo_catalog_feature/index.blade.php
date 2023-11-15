@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'entity'=> $entity ]) }}

@section('content')
    <div class="row ">
        <div class="col-12">
            <x-card expand>
                @if($entity->is_brand)
                    <x-nav-entity :entity="$entity"
                                  form="{!! json_encode( [ 'id'=>'form-repeater','route' => ['module.seo_catalog_feature.store', 'table'=>$table, 'id'=>$id] ]) !!}" >
                        @include('catalog::cms.seo_catalog_feature._form_brand')
                    </x-nav-entity>
                @else
                    <x-nav-entity :entity="$entity"
                                  form="{!! json_encode( [ 'id'=>'form-repeater','route' => ['module.seo_catalog_feature.store', 'table'=>$table, 'id'=>$id] ]) !!}" >
                        @include('catalog::cms.seo_catalog_feature._form_feature')
                    </x-nav-entity>
                @endif
            </x-card>
        </div>
    </div>
@endsection
