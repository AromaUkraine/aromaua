@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'items'=>[
     ['name'=>'cms.section'],
      ['name'=> __('cms.page_list'), 'slug'=>'section.section.index'],
      ['name'=>$page->name]
    ] ]) }}

@section('actions')
    <x-action
        href="{{ route('section.section.index') }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <x-card expand>
                {{$dataTable->table()}}
            </x-card>
        </div>
    </div>
@endsection

@push('scripts')
    {{$dataTable->scripts()}}
@endpush

