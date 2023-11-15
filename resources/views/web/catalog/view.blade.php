@extends('layouts.web')

@php($root = $root ?? null)
@php($ancestors = $category->ancestors ?? null)

@section('content')
    <x-page-breadcrumbs
        :page="$page"
        :root="$root"
        :ancestors="$ancestors"
    ></x-page-breadcrumbs>

    <v-catalog
        :category="{{json_encode($category->toArray())}}"
        icon_path="{{asset('images/web/svg/symbol/sprite.svg')}}"
    ></v-catalog>

    <div class="text-block">{!! $page->text !!} </div>
@endsection
