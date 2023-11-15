
<a class="btn @if($icon) btn-icon @endif {{$btn}} {{$class}} ml-1"
   @if($route) href="{{ url($route) }}" @else href="#" @endif
   @isset($toggle) {{ $toggle }} @endisset
   @if($tooltip) data-toggle="tooltip" data-placement="{{$placement}}" title="{{ \StringHelper::upper($name) }}" @endif>
    @if($icon)
        <i class="{{ $icon }}"> </i>
    @else
        {{ \StringHelper::upper($name) }}
    @endif
</a>
