@extends('layouts.cms')

{{ \Breadcrumbs::make([
    'items'=>[
    [
       'name'=>$page->name,
    ],
    [
       'name'=>'Создание виджета'
    ]
] ]) }}

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
            <x-form expand
                    options="{!! json_encode(['route' => ['developer.make_widget.store', [$page->id, $alias]], 'class'=>'form-horizontal']) !!} ">
                @include('developer::make_widget._form')
            </x-form>
        </div>
    </div>
@endsection



