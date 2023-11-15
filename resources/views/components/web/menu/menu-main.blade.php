<nav class="header__menu menu" id="js-menu">
    <ul class="menu__list">
        @forelse ($items as $item)
            @if($item->page)
                <li class="menu__item {{ $getActiveClass($item) }}">
                    <a class="menu__link  " href="{{ $getRoute($item->page->slug) }}">{{ $item->name }}  </a>
                    @if ($item->children->count())
                        <button class="menu__btn js-menu-btn" type="button"></button>
                        <div class="submenu">
                            <ul class="submenu__list">
                                @foreach($item->children as $level1)
                                    @if($level1->page)
                                        <li class="submenu__item">
                                            <a class="submenu__link" href="{{ $getRoute($level1->page->slug) }}">{{$level1->name}}</a>
                                            @if($level1->children->count())
                                                <button class="submenu__btn js-menu-btn" type="button"></button>
                                                <div class="submenu-2">
                                                    <ul class="submenu-2__list">
                                                        @foreach($level1->children as $level2)
                                                            @if($level2->page)
                                                                <li class="submenu-2__item">
                                                                    <a class="submenu-2__link" href="{{ $getRoute($level2->page->slug) }}">{{$level2->name}}</a>
                                                                    @if($level2->children->count())
                                                                        <button class="submenu__btn js-menu-btn" type="button"></button>
                                                                        <div class="submenu-2">
                                                                            <ul class="submenu-2__list">
                                                                                @foreach($level2->children as $level3)
                                                                                    @if($level3->page)
                                                                                        <li class="submenu-2__item">
                                                                                            <a class="submenu-2__link" href="{{ $getRoute($level3->page->slug) }}">{{$level3->name}}</a>
                                                                                            @if($level3->children->count())
                                                                                                <button class="submenu__btn js-menu-btn" type="button"></button>
                                                                                                <div class="submenu-2">
                                                                                                    <ul class="submenu-2__list">
                                                                                                        @foreach($level3->children as $level4)
                                                                                                            @if($level4->page)
                                                                                                                <li class="submenu-2__item">
                                                                                                                    <a class="submenu-2__link" href="{{ $getRoute($level4->page->slug) }}">{{$level4->name}}</a>
                                                                                                                </li>
                                                                                                            @endif
                                                                                                        @endforeach
                                                                                                    </ul>
                                                                                                </div>
                                                                                            @endif
                                                                                        </li>
                                                                                    @endif
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    @endif
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </li>
            @endif
        @empty
        @endforelse
    </ul>
    <div class="header__top-line-mobile">
        <div class="topline__container">

            <x-phone-top></x-phone-top>

            <x-menu-top key="{{'top-menu'}}"></x-menu-top>

            <x-language-switcher :page=$page></x-language-switcher>

        </div>
    </div>
</nav>
