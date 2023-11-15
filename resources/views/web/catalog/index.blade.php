@extends('layouts.web')

@php($root = $root ?? null)
@php($ancestors = $category->ancestors ?? null)

@section('content')
    <x-page-breadcrumbs
        :page="$page"
        :root="$root"
        :ancestors="$ancestors"
    ></x-page-breadcrumbs>

    <section class="catalog" >
        <h1 class="catalog__title h1">{{ $page->name }}</h1>
        <div class="catalog__cards cards cards-only-text">
            @forelse($categories as $category)
                <x-catalog-product-category :category="$category"></x-catalog-product-category>
            @empty
            @endforelse
        </div>
        <!-- BEGIN: pagination-->
        {{ $categories->links('components.web.pagination.default') }}
        <!-- END: pagination-->
      </section>
      <div class="text-block">{!! $page->text !!} </div>
@endsection
