

@push('scripts')
    <script src="{{ asset('tinymce/tinymce.js') }}"></script>
    <script>
        $(function(){
            tinymce.init({
                path_absolute : "/",
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
                    "table  directionality emoticons paste  code"
                ],
                toolbar: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect |link unlink anchor | image media | forecolor backcolor | print preview code ",
                language : '{{app()->getLocale()}}',
                file_picker_callback : function(callback, value, meta) {
                    var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                    var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                    var cmsURL =  '/cms/laravel-filemanager?editor=' + meta.fieldname;
                    if (meta.filetype == 'image') {
                        cmsURL = cmsURL + "&type=Images";
                    } else {
                        cmsURL = cmsURL + "&type=Files";
                    }

                    tinyMCE.activeEditor.windowManager.openUrl({
                        url : cmsURL,
                        title : '',
                        width : x * 0.8,
                        height : y * 0.8,
                        resizable : "yes",
                        close_previous : "no",
                        onMessage: (api, message) => {
                            callback(message.content);
                        }
                    });
                }

            });
        })
    </script>
@endpush

