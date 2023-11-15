@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'last'=>[ 'name'=> $page->name ] ]) }}

@section('actions')
    <x-action
        href="{{ route('developer.seo_page.index') }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row">
        <div class="col-6">

        </div>
    </div>
@endsection




