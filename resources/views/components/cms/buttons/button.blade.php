<button type="{{$type}}" class="btn btn-{{$class}} glow" {{ $htmlOptions }} >
    @if($icon)<i class="bx bx-{{ $icon }}"></i>@endif
    <span class="align-middle ml-25">{{ $title }}</span>
</button>
