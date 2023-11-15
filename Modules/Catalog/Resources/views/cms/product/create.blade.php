@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'last'=>[ 'name'=> __('cms.new_record') ] ]) }}

@section('actions')
    <x-action
        href="{{ route('catalog.product.index') }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row ">
        <div class="col-12">
            <x-form expand options="{!! json_encode(['route' => 'catalog.product.store']) !!} ">
                @include('catalog::cms.product._form',['product'=>null])
            </x-form>
        </div>
    </div>
@endsection





