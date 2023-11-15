

@push('scripts')
<script src="{{ asset('tinymce/tinymce.js') }}"></script>
<script>
    $(function(){
        tinymce.init({
            selector: '.tinymce#{{ $selector }}',
            height: 400,
            relative_urls: false,
            image_advtab: true ,
            // remove_script_host : true,
            plugins: [
               /* "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                "table directionality emoticons paste  filemanager code "*/
                "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons paste filemanager textcolor code"
            ],
            toolbar: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect |link unlink anchor | image media | forecolor backcolor | print preview code ",
            language : '{{app()->getLocale()}}',

            filemanager_access_key: '@filemanager_get_key()',
            // filemanager_sort_by: '',
            // filemanager_descending: '',
            filemanager_subfolder: '{{ (isset($subfolder) ? $subfolder : ' ') }}',
            filemanager_crossdomain: 0,
            external_filemanager_path: '@filemanager_get_resource(dialog.php)',
            filemanager_title:"{{__('cms.filemanager')}}" ,
            external_plugins: {
                "filemanager" : "{{asset("/vendor/responsivefilemanager/plugin.min.js")}}",
            },
        });
    })
</script>
@endpush

