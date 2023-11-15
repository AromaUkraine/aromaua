{{-- @include('ckfinder::setup')
<script type="text/javascript" src="{{ asset('js/ckfinder/ckfinder.js') }}"></script>
<script>
    CKFinder.config({
        connectorPath: @json(route('ckfinder_connector'))
    });

</script> --}}
{{-- <script src="https://cdn.ckeditor.com/ckeditor5/26.0.0/classic/translations/{{ app()->getLocale() }}.js"></script> --}}


<script src="https://cdn.ckeditor.com/ckeditor5/26.0.0/classic/translations/{{ app()->getLocale() }}.js"></script>
@push('scripts')

<script>
    var route_prefix = "/cms/filemanager";
    // ClassicEditor
    //     .create( document.querySelector(' .ckeditor#{{ $selector }}' ),{
    //         height: 100,
    //         filebrowserImageBrowseUrl: route_prefix + '?type=Images',
    //         filebrowserImageUploadUrl: route_prefix + '/upload?type=Images&_token={{csrf_token()}}',
    //         filebrowserBrowseUrl: route_prefix + '?type=Files',
    //         filebrowserUploadUrl: route_prefix + '/upload?type=Files&_token={{csrf_token()}}'
    //     } )
    //     .catch( error => {
    //         console.error( error );
    //     } );
</script>
 
    <script>

        // $(function(){
        //     console.log(window.ClassicEditor);
        // })
        // function MinHeightPlugin(editor) {
        //     this.editor = editor;
        // }

        // MinHeightPlugin.prototype.init = function() {
        //     this.editor.ui.view.editable.extendTemplate({
        //         attributes: {
        //             style: {
        //                 minHeight: '300px'
        //             }
        //         }
        //     });
        // };

        // ClassicEditor.builtinPlugins.push(MinHeightPlugin);

        ClassicEditor
            .create(document.querySelector('.ckeditor#{{ $selector }}'), {
                toolbar: {
                    items: [
                        "heading",
                        "bold",
                        "italic",
                        "blockQuote",
                        "link",
                        "|",
                        "ckfinder",
                        'imageStyle:alignLeft',
                        'imageStyle:alignCenter',
                        'imageStyle:alignRight',
                        "imageTextAlternative",
                        "|",
                        "indent",
                        "outdent",
                        "numberedList",
                        "bulletedList",
                        "mediaEmbed",
                        "insertTable",
                        "tableColumn",
                        "tableRow",
                        "mergeTableCells",
                        "|",
                        "selectAll",
                        "undo",
                        "redo",
                        "|"
                    ],
                    shouldNotGroupWhenFull: true
                },

                image: {
                    styles: [
                        'alignLeft',
                        'alignCenter',
                        'alignRight'
                    ],

                    // Configure the available image resize options.
                    resizeOptions: [{
                            name: 'resizeImage:original',
                            label: 'Original',
                            value: null
                        },
                        {
                            name: 'resizeImage:50',
                            label: '50%',
                            value: '50'
                        },
                        {
                            name: 'resizeImage:75',
                            label: '75%',
                            value: '75'
                        }
                    ],
                    toolbar: [
                        'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight',
                        '|',
                        'imageTextAlternative'
                    ]
                },
                // ckfinder: {
                //     // Use named route for CKFinder connector entry point
                //     uploadUrl: '/ckfinder/connector?command=QuickUpload&type=Images',
                //     language: '{{ app()->getLocale() }}'
                // },
                language: '{{ app()->getLocale() }}'

            })
            .then(editor => {
                // console.log(editor);
                // editor.ui.view.editable.element.style.height = '500px';
            })
            .catch(error => {
                console.error(error);
            });

        ClassicEditor.builtinPlugins.map(plugin => console.log(plugin.pluginName));

    </script>
@endpush
