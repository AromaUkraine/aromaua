@section('breadcrumbs')
    <ul class="breadcrumbs">
        @forelse($items as $item)
            @if(!$loop->last)
                <li class="breadcrumbs__item">
                    <a class="breadcrumbs__link" href="{{ $getRoute($item->slug) }}">{{ $getName($item) }}</a>
                </li>
            @else
                <li class="breadcrumbs__item">{{ $getName($item) }}</li>
            @endif
        @empty
        @endforelse
    </ul>
@endsection
