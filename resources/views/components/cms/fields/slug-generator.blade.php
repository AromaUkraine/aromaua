<x-input
    :model="$model"
    name="{{ $name }}"
    label="{{ $label }}"
    lang="{{ $lang }}"
    id="{{ $name }}"
    options="{!! json_encode($options) !!}"
>
</x-input>

@if($languages)
    @foreach($languages as $lang)
        @push('scripts')
            <script>
                $('#{{$getWatchId($lang->short_code)}}').change( function(e){
                    getSlugValue(this, {{$setId($lang->short_code)}});
                })
            </script>
        @endpush
    @endforeach
@else
    @push('scripts')
        <script>
            $('#{{$getWatchId()}}').change( function(e){
                getSlugValue(this, {{$setId()}});
            })
        </script>
    @endpush
@endif
@push('scripts')
    <script>
        function getSlugValue(target, element) {
            var data = {
                url : '/api/slug',
                data: {value : $(target).val()},
                dataType:'json',
                type: 'post'
            }
            $.sendAjax( data , function (res) {
                $(element).val(res.slug);
            });
        }
    </script>
@endpush
