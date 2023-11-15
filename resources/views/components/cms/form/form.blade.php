{!! Form::open($options) !!}
<div class="card">
    <div class="card-header">
        {{ $title ?? null }}
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
            <div class="col-sm-12 d-flex justify-content-end pr-0 py-1">
                @yield('form-buttons')
            </div>
        </div>
    </div>
    <footer class="footer-form--sticky">
        <div class="d-flex justify-content-md-end justify-content-center pr-md-1">
            @yield('form-fixed-buttons')
        </div>
    </footer>
</div>

{!! Form::close() !!}
