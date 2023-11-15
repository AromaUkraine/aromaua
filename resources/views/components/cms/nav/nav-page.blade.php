@if($form)
    {!! Form::open( $form,['novalidate'=>'novalidate'] ) !!}
@endif
<div class="row pills-stacked">
    <div class="col-md-3">
        <ul class="nav nav-pills flex-column text-center text-md-left">
            @foreach($getItems() as $key=>$value)
                <li class="nav-item" id="{{$key}}" >
                    <a class="nav-link {{$setActive($value['slug'], $value['params'])}} "  href="{{route($value['slug'], $value['params'])}}">
                        @isset($value['icon'])<i class="{{ $value['icon'] }}"></i>@endisset
                        <span> {{  $value['name'] }} </span>
                    </a>
                </li>
            @endforeach
        </ul>
{{--        {{ var_dump($value['params']) }}--}}
        <ul class="nav nav-pills flex-column text-center mt-2 text-md-left">
            <li class="nav-item" >
                <a class="nav-link" href="{{route('module.gallery.index', ['page'=>2,'table'=>'articles','id'=>1])}}">{{__('cms.gallery')}}</a>
            </li>
        </ul>
    </div>
    <div class="col-md-9">

        {{ $slot }}

        <div class="col-sm-12 d-flex justify-content-end pr-0 py-1">
            @yield('form-buttons')
        </div>
        <footer class="footer-form--sticky">
            <div class="d-flex justify-content-md-end justify-content-center pr-md-3 ">
                @yield('form-fixed-buttons')
            </div>
        </footer>
    </div>
</div>
@if($form)
    {!! Form::close() !!}
@endif
