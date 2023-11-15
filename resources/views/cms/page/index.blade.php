@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'items'=>[
     ['name'=>'cms.section'],
     ['name'=> $page->name, 'slug'=>(new \App\Services\PermissionService())->getPermissionByPage($page), 'params'=>$page->id]
    ] ]) }}

@section('content')
    <div class="row ">
        <div class="col-12">
            <x-card expand>
                <x-nav-page :page="$page" form >
                    @include('cms.page._form',['page'=>$page])
                </x-nav-page>
            </x-card>
        </div>
    </div>
@endsection


