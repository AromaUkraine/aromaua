@extends('layouts.cms')



@section('actions')
    <x-action
        href="{{ route('root.backup.create') }}"
        class="success text-capitalize"
        title="{{__('cms.buttons.create')}}"
        icon="bx bx-plus"></x-action>

@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <x-card expand>

                @if ( Session::has('success') )
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ Session::get('success') }}
                </div>
                @endif

                @if ( Session::has('update') )
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ Session::get('update') }}
                </div>
                @endif

                @if ( Session::has('delete') )
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ Session::get('delete') }}
                </div>
                @endif

                <table class="table dataTable no-footer" id="example">
                    <thead>
                        <tr role="row">
                            <th>#</th>
                            <th>File Name</th>
                            <th>File Size</th>
                            <th>Created Date</th>
                            <th>Created Age</th>
                            <th></th>
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
                "ajax": "{{ route('root.backup.index') }}",
                "displayLength": 25,
                "columns": [
                    { "data": "id" },
                    { "data": "file_name" },
                    { "data": "file_size" },
                    { "data": "created_date" },
                    { "data": "created_age" },
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
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
                        });
                    }
                })
            })
        } );
    </script>
@endpush