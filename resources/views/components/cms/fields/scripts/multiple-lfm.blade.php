@if($languages)
@foreach($languages as $lang)
    @push('scripts')
        <script>
            var route_prefix = '/cms/laravel-filemanager';
            $('.dropzone#multiple-file-{{$lang->short_code}}').fmdropzone({
                type:'multiple',
                base_url: "{{config('rfm.base_url')}}",
            });
            lfm('multiple-file-{{$lang->short_code}}', 'dz-gallery-{{$lang->short_code}}', 'image', {prefix: route_prefix});
        </script>
    @endpush
@endforeach
@else
@push('scripts')
    <script>
         var route_prefix = '/cms/laravel-filemanager';
        $('.dropzone#multiple-file-{{$setName()}}').fmdropzone({
            type:'multiple',
            base_url: "{{config('rfm.base_url')}}",
        });
        lfm('multiple-file-{{$setName()}}', 'dz-gallery-{{$setName()}}', 'image', {prefix: route_prefix});
    </script>
@endpush
@endif
