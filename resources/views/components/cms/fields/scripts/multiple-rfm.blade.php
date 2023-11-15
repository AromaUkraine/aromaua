@if($languages)
    @foreach($languages as $lang)
        @push('scripts')
            <script>
                $('.dropzone#multiple-file-{{$lang->short_code}}').fmdropzone({
                    type:'multiple',
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
            $('.dropzone#multiple-file-{{$setName()}}').fmdropzone({
                type:'multiple',
                base_url: "{{config('rfm.base_url')}}",
                image_base_path: "{{config('rfm.upload_dir')}}",
                thumbs_base_path: "/{{config('rfm.thumbs_base_path')}}",
                onModal:true
            });
        </script>
    @endpush
@endif