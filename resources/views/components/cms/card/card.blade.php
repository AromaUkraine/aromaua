<div class="card">
    <div class="card-header">
        <h4 class="card-title text-transform-none">{{ $title ?? null }}</h4>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                @if($collapse)
                    <li>
                        <a data-action="collapse">
                            <i class="bx bx-chevron-down"></i>
                        </a>
                    </li>
                @endif
                @if($expand)
                    <li>
                        <a data-action="expand">
                            <i class="bx bx-fullscreen"></i>
                        </a>
                    </li>
                @endif
                @if($reload)
                    <li>
                        <a data-action="reload">
                            <i class="bx bx-revision"></i>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    <div class="card-content">
        <div class="card-body">
            {{ $slot }}
        </div>
    </div>
    <div class="card-footer ">
        @yield('card-footer')
    </div>
</div>
