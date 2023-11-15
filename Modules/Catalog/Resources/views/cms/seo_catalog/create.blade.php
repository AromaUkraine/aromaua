@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'last'=>[ 'name'=> __('cms.new_record') ] ]) }}

@section('actions')
    <x-action
        href="{{ route('catalog.seo_catalog.index') }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row ">
        <div class="col-12">
            <x-form expand options="{!! json_encode(['route' => 'catalog.seo_catalog.store']) !!} ">
                @include('catalog::cms.seo_catalog._form',['seo'=>null])
            </x-form>
        </div>
    </div>
@endsection





