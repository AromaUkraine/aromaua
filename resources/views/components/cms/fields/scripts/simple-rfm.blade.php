@if($languages)
    @foreach($languages as $lang)
        @push('scripts')
            <script>
                $('.dropzone#single-file-{{$lang->short_code}}').fmdropzone({
                    type:'single',
                    base_url: "{{config('rfm.base_url')}}",
                    image_base_path: "{{config('rfm.upload_dir')}}",
                    thumbs_base_path: "/{{config('rfm.thumbs_base_path')}}",
                    onModal:true
                });
            </script>
        @endpush
    @endforeach
@else
    @push('scripts')
        <script>
            $('.dropzone#single-file-{{$setName()}}').fmdropzone({
                type:'single',
                base_url: "{{config('rfm.base_url')}}",
                image_base_path: "{{config('rfm.upload_dir')}}",
                thumbs_base_path: "/{{config('rfm.thumbs_base_path')}}",
                onModal:true
            });
        </script>
    @endpush
@endif
