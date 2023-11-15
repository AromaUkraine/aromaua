@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'entity'=> $entity ]) }}

@section('content')
    <div class="row ">
        <div class="col-12">
            <x-card expand>
                <x-nav-entity :entity="$entity" >
                    {{$dataTable->table()}}
                </x-nav-entity>
            </x-card>
        </div>
    </div>
@endsection

@push('scripts')
    {{$dataTable->scripts()}}
@endpush
