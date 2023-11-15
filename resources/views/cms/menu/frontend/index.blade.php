@extends('layouts.cms')



@section('content')
    <div class="row">
        <div class="col-12" >
            <x-card expand>
                <x-menu-nested-tree from="frontend" ></x-menu-nested-tree>
            </x-card>
        </div>
    </div>
@endsection

