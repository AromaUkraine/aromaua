<h5 class="content-header-title float-left pr-1 mb-0 "> {{ __($title) }}</h5>
@if($breadcrumbs)
    <div class="breadcrumb-wrapper col-12">
        <ol class="breadcrumb p-0 mb-0">
            @foreach($breadcrumbs as $item)

                <li class="breadcrumb-item">
                    @isset($item['slug'])
                        <a href=" {{ $setRoute($item) }} ">{{ $setName($item['name']) }}</a>
                    @else
                        {{ $setName($item['name'])}}
                    @endisset
                </li>
            @endforeach
        </ol>
    </div>
@endif
