@extends('layouts.cms')

@section('actions')
    <x-action
        href="{{ route('root.log.destroy') }}"
        class="danger destroy_all"
        title="{{__('cms.log_destroy_all')}}"
        icon="bx bx-trash"></x-action>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <x-card expand>
                <x-advanced-filter options="{!! json_encode(['route' => 'root.log.index']) !!}" >
                    @include('synchronize::log.filter')
                </x-advanced-filter>
                <table class="table dataTable no-footer" id="example">
                    <thead>
                        <tr role="row">
                            <th>#</th>
                            <th style="width: 150px;">{{ __('cms.log_date') }}</th>
                            <th>{{ __('cms.log_message') }}</th>
                            <th>{{ __('cms.log_context') }}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </x-card>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "ajax": "{{ route('root.log.index') }}",
                "displayLength": 25,
                "columns": [
                    { "data": "id" },
                    { "data": "datetime" },
                    { "data": "message" },
                    { "data": "context" },
                ],
                "order": [0, "desc"],
                "dom": `<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>
                        <'row'<'col-sm-12 mb-1 table-responsive'tr>>
                        <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>`,
                "language": {
                    "url": "{{ asset('/vendors/datatables/lang/' . \App::getLocale() . '.json') }}"
                }
            });

            $('.destroy_all').click(function(e){
                e.preventDefault();
                var self = this;
                var data = {
                    title: "{{__('datatable.delete.title')}}",
                    message: "{{__('datatable.delete.text')}}",
                    confirmButtonText: "{{ __('datatable.delete.confirmButtonText') }}",
                    cancelButtonText: "{{ __('datatable.delete.cancelButtonText') }}",
                }
                $.confirm(data, function (result) {
                    if(result){
                        $.sendAjax({url: $(self).attr('href'), type: "DELETE", dataType:'json'}, function (response) {
                           toastr.success(response.message, response.title);
                           location.reload();
                        });
                    }
                })
            })

        } );
    </script>
@endpush

