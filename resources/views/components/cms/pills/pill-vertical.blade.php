<div class="row pills-stacked">
    <div class="col-md-1 mb-2 mb-md-0 pills-stacked">
         <ul class="nav nav-pills flex-column">
            @foreach($items as $key=>$item)
                 <li class="nav-item">
                     <a class="nav-link d-flex align-items-center @if( $loop->first ) active @endif"
                        id="stacked-pill-{{ $item['id'] ?? $key }}"
                        data-toggle="pill"
                        href="#vertical-pill-{{ $item['id'] ?? $key }}"
                        aria-expanded="true">
                        @isset($item['icon'])<i class="{{ $item['icon'] }}"></i>@endisset
                        <span> {{ $item['id'] ?? $item['name'] }} </span>
                     </a>
                 </li>
            @endforeach
        </ul>
    </div>
    <div class="col-md-11">
        <div class="tab-content {{ $options['class'] ?? '' }}">
            @foreach($items as $key=>$item)
                <div role="tabpanel"
                     class="tab-pane @if( $loop->first ) active @endif"
                     id="vertical-pill-{{ $item['id'] ?? $key }}"
                     aria-labelledby="stacked-pill-{{ $item['id'] ?? $key }}"
                     aria-expanded="true">
                    {{ $$key ?? ''}}
                </div>
            @endforeach
        </div>
    </div>
</div>

