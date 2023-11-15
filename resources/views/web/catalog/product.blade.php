@extends('layouts.web')

@php($root = $root ?? null)
@php($ancestors = $category->ancestors ?? null)

@section('content')
    <x-page-breadcrumbs
        :page="$page"
        :root="$root"
        :category="$category"
        :ancestors="$ancestors"
    ></x-page-breadcrumbs>

    <v-product-view >
        <article class="product" >
            <header class="product__header">
                <h1 class="product__title">{{ $product->name }} {{ $product->product_code }}</h1>
                <div class="product__header-content">
                    <div class="product__number">Номер: <span>{{ $product->product_code }}</span>
                    </div>
                    <a class="product__print" href="#" >
                        <svg class="svg-sprite product__icon" width="26px" height="26px">
                            <use xlink:href="{{ asset('images/web/svg/symbol/sprite.svg#print') }}"></use>
                        </svg>
                    </a>
                </div>
            </header>
            <section class="product__main">
                <x-product-gallery :product="$product"></x-product-gallery>
                <x-product-document-list
                    :product="$product"
                    :category="$category"
                ></x-product-document-list>
            </section>
            <section class="product__description product-desc">
                {!!  $product->description !!}
            </section>
            <section class="product__text product-desc">
                {!!  $product->text !!}
            </section>
        </article>
    </v-product-view>

@endsection
