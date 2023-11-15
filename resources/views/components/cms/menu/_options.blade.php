@if($menu->children && $menu->children->count())

    <option class="ml-{{$level}}" value="{{$menu->id}}" >{{ $indent($level) }} {!! $menu->name !!} </option>
    @foreach($menu->children as $item)
        @include('components.cms.menu._options',['menu'=>$item, 'level'=>++$level,'parent_level'=>--$level])
    @endforeach
@else

    <option class="ml-{{$level}}" value="{{$menu->id}}"  > {{ $indent($level) }} {!! $menu->name !!}  </option>
@endisset
