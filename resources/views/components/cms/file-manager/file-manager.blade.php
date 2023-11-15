<div {{ $options  }} id="all" data-url="@filemanager_get_resource(dialog.php)?{{ $params }}&akey=@filemanager_get_key()"></div>

@push('scripts')
    <script>
        $(function () {
            $.loader('show');
            var container = $('#all');
            var obj = document.createElement('object');
            $(obj).attr('data', container.data('url'));
            $(obj).css({width: '100%', height: '100vh'});
            container.empty().append(obj);
            $(obj).on('load', function () {
                $.loader('hide')
            });
        })
    </script>
@endpush
