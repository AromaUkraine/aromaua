{{-- vertical-menu --}}
@if($configData['mainLayoutType'] == 'vertical-menu')
    <div
        class="main-menu menu-fixed @if($configData['theme'] === 'light') {{"menu-light"}} @else {{'menu-dark'}} @endif menu-accordion menu-shadow"
        data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto">
                    {{--          {{ route('cms.home.index') }}--}}
                    <a class="navbar-brand" href="">
                        {{-- <div class="brand-logo">
                            <img src="{{asset('images/logo/logo-IU.png')}}" class="logo" alt="">
                        </div> --}}
                        <h2 class="brand-text mb-0">
                            @if(!empty($configData['templateTitle']) && isset($configData['templateTitle']))
                                {{$configData['templateTitle']}}
                            @endif
                        </h2>
                    </a>
                </li>
                <li class="nav-item nav-toggle">
                    <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                        <i class="bx bx-x d-block d-xl-none font-medium-4 primary"></i>
                        <i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block primary"
                           data-ticon="bx-disc"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main">
                <li class="nav-item">
                    <a href="{{ \Route::has('main') ? route('main') : url('/') }}" target="_blank">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="menu-item mr-1">На  главную  </span>

                    </a>
                </li>
            </ul>
            @isset($page)
                <x-cms-menu :page="$page"/>
            @else
                <x-cms-menu/>
            @endisset
            <ul class="navigation navigation-main">
                <li class="nav-item">
                    <a href="{{ route('synchronize.import') }}" target="_blank">
                        <i class="fas fa-file-import"></i>
                        <span class="menu-title"> Синхронизация запуск </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endif

{{-- vertical-box-menu --}}
@if($configData['mainLayoutType'] == 'vertical-menu-boxicons')
    <div
        class="main-menu menu-fixed @if($configData['theme'] === 'light') {{"menu-light"}} @else {{'menu-dark'}} @endif menu-accordion menu-shadow"
        data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto">
                    <a class="navbar-brand" href="{{ route('cms.user.index') }}">
                        <div class="brand-logo">
                            <img src="{{asset('images/logo/logo-IU.png')}}" class="logo" alt="">
                        </div>
                        <h2 class="brand-text mb-0">
                            @if(!empty($configData['templateTitle']) && isset($configData['templateTitle']))
                                {{$configData['templateTitle']}}
                            @endif
                        </h2>
                    </a>
                </li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
                            class="bx bx-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i
                            class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary"
                            data-ticon="bx-disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation"
                data-icon-style="">
                @if(!empty($menuData[2]) && isset($menuData[2]))
                    @foreach ($menuData[2]->menu as $menu)
                        @if(isset($menu->navheader))
                            <li class="navigation-header"><span>{{$menu->navheader}}</span></li>
                        @else
                            <li class="nav-item {{(request()->is($menu->url.'*')) ? 'active' : '' }}">
                                <a href="@if(isset($menu->url)){{asset($menu->url)}} @endif" @if(isset($menu->newTab)){{"target=_blank"}}@endif>
                                    @if(isset($menu->icon))
                                        <i class="{{$menu->icon}}"></i>
                                    @endif
                                    @if(isset($menu->name))
                                        <span class="menu-title">{{ __('locale.'.$menu->name)}} </span>
                                    @endif
                                    @if(isset($menu->tag))
                                        <span class="{{$menu->tagcustom}}">{{$menu->tag}}</span>
                                    @endif
                                </a>
                                @if(isset($menu->submenu))
                                    @include('panels-to-delete.sidebar-submenu',['menu' => $menu->submenu])
                                @endif
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
@endif
