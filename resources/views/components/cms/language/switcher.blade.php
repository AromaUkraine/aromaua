<li class="dropdown dropdown-language nav-item">
    <a class="dropdown-toggle nav-link" id="dropdown-flag"  href="javascript:void(0);" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
        <i class="flag-icon flag-icon-{{$getFlag($current)}}"></i>
        <span class="selected-language">{{$getName($current)}} </span>
    </a>
    <div class="dropdown-menu" aria-labelledby="dropdown-flag">
        @foreach($languages as $lang)
        <a class="dropdown-item select-language" href="javascript:void(0);" data-language="{{$lang->short_code}}">
            <i class="flag-icon flag-icon-{{$lang->short_code}} mr-50"></i> {{$lang->name}}
        </a>
        @endforeach
    </div>
</li>

@push('scripts')
    <script>
        $('.select-language').click(function (){
            console.log('click');
            let data = {
                url: "{{route('language_switch')}}",
                data: {lang:$(this).data('language')},
                type: 'GET'
            }
            $.sendAjax(data, function (response){
                location.reload();
            });
        });
    </script>
@endpush
