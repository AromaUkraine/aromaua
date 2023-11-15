<ul class="{{ $ulClass }}" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="lines" >
    @foreach($menu as $item)
        @isset($item->permission)
            @permission($item->permission->slug)
                <li class="{{$liClass}}  {{ $getActive($item) }} ">
                    <a href="{{ $getUrl($item) }}">
                        @if(isset($item->icon))
                            <i class="{{ $item->icon }}" ></i>
                        @endif
                        <span class="{{ $spanClass }}">  {{$getName($item)}}  </span>
                    </a>
                    @if($item->children->count())
                        @include('components.cms.menu.menu',[
                            'menu' => $item->children,
                            'ulClass'=>$ulChildrenClass,
                            'liClass'=>$liChildrenClass,
                            'spanClass'=>$spanChildrenClass
                         ])
                    @endif
                </li>
            @endpermission
        @else
            <li class="{{$liClass}} {{ $getActive($item) }} ">
                <a href="{{ $getUrl($item) }}">
                    @if(isset($item->icon))
                        <i class="{{ $item->icon }}" ></i>
                    @endif
                   <span class="{{ $spanClass }}"> {{$getName($item)}}  </span>
                </a>
                @if($item->children->count())
                    @include('components.cms.menu.menu',[
                        'menu' => $item->children,
                        'ulClass'=>$ulChildrenClass,
                        'liClass'=>$liChildrenClass,
                        'spanClass'=>$spanChildrenClass
                     ])
                @endif
            </li>
        @endisset

    @endforeach
</ul>
