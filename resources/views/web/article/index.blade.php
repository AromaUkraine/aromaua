@extends('layouts.web')

@section('content')
    <x-page-breadcrumbs :page="$page"></x-page-breadcrumbs>
    <section class="blog">
        <h1>{{ $page->name }}</h1>
        @forelse($articles as $article)
            <x-article-item :item="$article"></x-article-item>
        @empty
        @endforelse
        {{ $articles->links('components.web.pagination.default') }}
    </section>
@endsection

