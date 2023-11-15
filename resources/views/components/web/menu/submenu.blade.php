@dd($item->page)
{{--<div class=" @if (!$level) submenu @else submenu-2 @endif">--}}
{{--    <ul class=" @if (!$level) submenu__list @else submenu-2__list @endif">--}}
{{--        @forelse ($items as $item)--}}
{{--            <li class=" @if (!$level) submenu__item @else submenu-2__item @endif">--}}
{{--                <a class="@if (!$level) submenu__link @else submenu-2__link @endif" href="{{ $getRoute($item->page->slug) }}">{{ $item->page->name }} {{}}</a>--}}

{{--                @if ($item->children->count())--}}
{{--                    <button class="submenu__btn js-menu-btn" type="button"></button>--}}
{{--                    @include('components.web.menu.submenu', ['items'=>$item->children,'level'=> $setLevel($level,$item)])--}}
{{--                @endif--}}

{{--            </li>--}}
{{--        @empty--}}
{{--        @endforelse--}}
{{--    </ul>--}}
{{--</div>--}}
