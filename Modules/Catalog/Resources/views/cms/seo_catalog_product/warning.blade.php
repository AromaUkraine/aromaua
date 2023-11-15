@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'entity'=> $entity ]) }}

@section('content')
    <div class="row ">
        <div class="col-12">
            <x-card expand>
                <x-nav-entity :entity="$entity"  >
                    <div class="alert bg-rgba-danger alert-dismissible my-2" role="alert">

                        <div class="d-flex align-items-center">
                            <i class="bx bx-error"></i>
                            <span>
                               К странице не добавлена ни одна характеристика!
                             </span>
                        </div>
                    </div>
                </x-nav-entity>
            </x-card>
        </div>
    </div>
@endsection


