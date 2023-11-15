<div class="row pills-stacked">
    <div class="col-md-3">

        @if ($page_menu)
            <ul class="nav nav-pills mb-3 flex-column text-center text-md-left">
                @foreach ($page_menu as $key => $value)
                    <li class="nav-item" id="{{ $key }}">
                        <a class="nav-link {{ $getActive($value['slug'], $value['params']) }}" href="{{ route($value['slug'], $value['params']) }}">
                            @isset($value['icon'])<i class="{{ $value['icon'] }}"></i>@endisset
                            <span> {{ $setName($value['name']) }} </span>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif

        @if ($entity_menu)
            <h4 class="card-title  d-flex"></h4>
            <ul class="nav nav-pills flex-column text-center text-md-left">
                @foreach ($entity_menu as $key => $value)

                    <li class="nav-item" id="{{ $key }}">
                        <a class="nav-link {{ $getActive($value['slug'], $value['params']) }}" href="{{ route($value['slug'], $value['params']) }}">
                            @isset($value['icon'])<i class="{{ $value['icon'] }}"></i>@endisset
                            <span> {{ $setName($value['name']) }} </span>
                        </a>
                    </li>

                @endforeach
            </ul>
        @endif

    </div>
    <div class="col-md-9">
        @if ($form)
            {!! Form::open($form, ['novalidate' => 'novalidate']) !!}
        @endif
        {{ $slot }}
        <div class="col-sm-12 d-flex justify-content-end pr-0 py-1">
            @yield('form-buttons')
        </div>
        <footer class="footer-form--sticky">
            <div class="d-flex justify-content-md-end justify-content-center pr-md-3 ">
                @yield('form-fixed-buttons')
            </div>
        </footer>
        @if ($form)
            {!! Form::close() !!}
        @endif
    </div>
</div>
