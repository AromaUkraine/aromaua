@extends('layouts.web')
@section('content')
    <x-page-breadcrumbs
        :page="$page"
        :root="$root"
    ></x-page-breadcrumbs>
    <x-article-view :page="$page" :article="$article"></x-article-view>
@endsection

