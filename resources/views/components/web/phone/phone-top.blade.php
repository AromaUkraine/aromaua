<div class="topline__phones">
    @forelse($phones as $phone)
        @if(!empty($getNumber($phone)))
        <a class="topline__link" href="{{$getLink($phone)}}">{{$getTrans($phone)}} {{$getNumber($phone)}}</a>
        @endif
    @empty
    @endforelse
</div>
