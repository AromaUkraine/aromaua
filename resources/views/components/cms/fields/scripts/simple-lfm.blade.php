@if($languages)
@foreach($languages as $lang)
    @push('scripts')
        <script>
            var route_prefix = '/cms/laravel-filemanager';
            $('.dropzone#single-file-{{$lang->short_code}}').fmdropzone({
                type:'single',
                base_url: "{{config('rfm.base_url')}}",
            });
            lfm('single-file-{{$lang->short_code}}', 'dz-image-{{$lang->short_code}}', 'image', {prefix: route_prefix});
        </script>
    @endpush
@endforeach
@else
@push('scripts')
    <script>
         var route_prefix = '/cms/laravel-filemanager';
        $('.dropzone#single-file-{{$setName()}}').fmdropzone({
            type:'single',
            base_url: "{{config('rfm.base_url')}}",
        });
        lfm('single-file-{{$setName()}}', 'dz-image-{{$setName()}}', 'image', {prefix: route_prefix});
    </script>
@endpush
@endif
